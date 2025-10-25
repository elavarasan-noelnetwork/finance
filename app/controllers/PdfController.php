<?php
/* ======================================
  Filename: PdfController.php
  Author: Ameen
  Description: Generates PDF form identical to application_of_units.pdf
  ======================================= */

namespace app\controllers;

use core\View as View;
use app\models\Model;
use setasign\Fpdi\Tcpdf\Fpdi;
use app\controllers\CustomPdfExceptionController;
use app\models\LoanModel;

class MyPDF extends Fpdi
{
    // Optional footer
    public function Footer()
    {
        if ($this->getPage() > 1) {
            $this->SetY(-10);
            $this->SetFont('helvetica', '', 9);
            $this->SetTextColor(80, 80, 80);
            $this->Cell(0, 10, 'Page ' . $this->getAliasNumPage() . ' / ' . $this->getAliasNbPages(), 0, 0, 'R');
        }
    }

    // Optional watermark (can be removed if not needed)
    public function drawWatermark($text = 'CONFIDENTIAL')
    {
        $fontSize = 30;
        $this->SetFont('helvetica', 'B', $fontSize);
        $this->SetTextColor(200, 200, 200);
        $this->SetAlpha(0.2, 'Multiply');

        $pageWidth  = $this->getPageWidth();
        $pageHeight = $this->getPageHeight();
        $cellWidth  = 200;
        $textHeight = $fontSize * 0.35;
        $x = 20;
        $y = ($pageHeight - $textHeight) / 2;

        $this->SetXY($x, $y);
        $this->StartTransform();
        $this->Rotate(45, $pageWidth / 2, $pageHeight / 2);
        $this->MultiCell($cellWidth, 6, $text, 0, 'C', false);
        $this->StopTransform();

        $this->SetAlpha(1);
    }
}

class PdfController extends Controller
{

    public function downloadFinalDocuments($route)
    {

        $loanDetailsArray = array();
        if(!empty($route['uri'][1])){
           $applicationId = $route['uri'][1]; 
            //retrieve loan and user details
            $loanObject = new LoanModel();
            $loanDetailsArray = $loanObject->getOne("zl_id = '{$applicationId}'");           
        }
    
        if (
            !empty($loanDetailsArray['zl_code']) && !empty($loanDetailsArray['zl_final_doc_generated'])
            &&  !empty($loanDetailsArray['zl_app_units_doc']) && !empty($loanDetailsArray['zl_trust_authority_doc'])
            && !empty($loanDetailsArray['zl_final_deed_doc'])
        ) {

            // List of PDF files (absolute or relative paths)
            $files = [
                PDF_UPLOAD_PATH . $loanDetailsArray['zl_app_units_doc'],
                PDF_UPLOAD_PATH . $loanDetailsArray['zl_trust_authority_doc'],
                PDF_UPLOAD_PATH . $loanDetailsArray['zl_final_deed_doc'],
            ];

            // Name for the zip file
            $zipFileName = $loanDetailsArray['zl_code'].'_final_documents.zip';
            $zipFilePath = sys_get_temp_dir() . '/' . $zipFileName;

            // Initialize ZipArchive
            $zip = new \ZipArchive();
            if ($zip->open($zipFilePath, \ZipArchive::CREATE | \ZipArchive::OVERWRITE) !== TRUE) {
                http_response_code(500);
                exit("❌ Unable to create ZIP file");
            }

            // Add files to zip
            $filesAdded = 0;
            foreach ($files as $file) {
                if (file_exists($file)) {
                    $zip->addFile($file, basename($file));
                    $filesAdded++;
                }
            }
            $zip->close();

            // If no files were added, return error
            if ($filesAdded === 0 || !file_exists($zipFilePath)) {
                http_response_code(404);
                exit("❌ No files found to download");
            }

            // Clear output buffer before sending headers (important if any output before)
            if (ob_get_length()) {
                ob_end_clean();
            }

            // Set headers to force download
            header('Content-Description: File Transfer');
            header('Content-Type: application/zip');
            header('Content-Disposition: attachment; filename="' . $zipFileName . '"');
            header('Content-Transfer-Encoding: binary');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($zipFilePath));

            // Output the file
            readfile($zipFilePath);

            // Clean up temp file
            unlink($zipFilePath);
            exit;
        }
        else{
            http_response_code(500);
            exit("❌ Unable to create ZIP file");            
        }
    }

    public static function generateFinalDocuments($loanId)
    {

        $propertyDetailsArray = array();
        //retrieve loan and user details
        $loanObject = new LoanModel();
        $loanDetailsArray = $loanObject->getOne("zl_id = '{$loanId}'");
        if (empty($loanDetailsArray)) {
            return false;
        } else {
            $userModel = new \app\models\UserModel();
            $userDetailsArray = $userModel->getOne("zlu_id = '{$loanDetailsArray['zl_user_id']}'");
            if (empty($userDetailsArray)) {
                return false;
            } else {

                $currentdate = date('Y-m-d');

                $property_name  = PROPERTY_NAME_ARRAY[$loanDetailsArray['zl_property_id']] ?? '';
                $property_id  = $loanDetailsArray['zl_property_id'] ?? '';
                $property_name_prefix  = PROPERTY_NAME_PREFIX_ARRAY[$loanDetailsArray['zl_property_id']] ?? '';
                $applicant_name = "";
                if (!empty($loanDetailsArray['zl_buying_as_id'])) {
                    if ($loanDetailsArray['zl_buying_as_id'] == 1) {
                        $applicant_name = $loanDetailsArray['zl_fname'] . " " . $loanDetailsArray['zl_lname'];
                        if (!empty($loanDetailsArray['zl_fname2']) && !empty($loanDetailsArray['zl_lname2'])) {
                            $applicant_name .= ' & ' . $loanDetailsArray['zl_fname2'] . " " . $loanDetailsArray['zl_lname2'];
                        }
                    } elseif ($loanDetailsArray['zl_buying_as_id'] == 2) {
                        $applicant_name = $loanDetailsArray['zl_trust_name'] ?? '';
                    } elseif ($loanDetailsArray['zl_buying_as_id'] == 3) {
                        $applicant_name = $loanDetailsArray['zl_smsf_name'] ?? '';
                    }
                }
                $address  = $userDetailsArray['zlu_address'] ?? '';
                $unit_class = '1 C Class';
                $total_amount = '500,000.00';
                $loan_code = $loanDetailsArray['zl_code'] ?? '';

                // Convert to timestamp
                $timestamp = strtotime($currentdate);
                $app_date         = date('d', $timestamp);       // 25
                $app_month_name   = date('F', $timestamp);       // October
                $app_month        = date('m', $timestamp);       // 10
                $app_year_suffix  = date('y', $timestamp);       // 25
                $app_year         = date('Y', $timestamp);       // 2025                

                //generate input array
                $propertyDetailsArray = [
                    'property_name' => $property_name,
                    'property_id' => $property_id,
                    'property_name_prefix' => $property_name_prefix,
                    'applicant_name' => $applicant_name,
                    'address' => $address,
                    'unit_class' => $unit_class,
                    'total_amount' => $total_amount,
                    'loan_code' => $loan_code,
                    'app_date' => $app_date,
                    'app_month_name' => $app_month_name,
                    'app_month' => $app_month,
                    'app_year_suffix' => $app_year_suffix,
                    'app_year' => $app_year,
                ];

                //generate document
                if (is_array(PDF_FILE_TYPE_ARRAY) && count(PDF_FILE_TYPE_ARRAY) > 0) {
                    $succesCreatedPdfArray = [];
                    foreach (PDF_FILE_TYPE_ARRAY as $fileTypeId => $fileTypename) {
                        try {
                            $createdFileName = self::generatePdf($fileTypeId, $propertyDetailsArray);
                            if ($createdFileName) {
                                $succesCreatedPdfArray[$fileTypeId] = $createdFileName;
                            }
                            //$file = self::generatePdf(3, $propertyDetailsArray);
                        } catch (CustomPdfExceptionController $e) {
                            return false;
                        }
                    }
                } else {
                    return false;
                }


                //if all files generated successfully do db insert progress
                if (is_array($succesCreatedPdfArray) && count($succesCreatedPdfArray) == 3) {

                    //update loan details
                    $loanObject = new LoanModel();
                    $whereUpdate["zl_id"] = $loanId;
                    $upd_ip_data['zl_final_doc_generated'] = 1;
                    $upd_ip_data['zl_app_units_doc'] = $succesCreatedPdfArray[1] ?? '';
                    $upd_ip_data['zl_trust_authority_doc'] = $succesCreatedPdfArray[2] ?? '';
                    $upd_ip_data['zl_final_deed_doc'] = $succesCreatedPdfArray[3] ?? '';
                    $updateResult =  $loanObject->update($upd_ip_data, $whereUpdate);
                    if ($updateResult) {
                        return true;
                    } else {
                        return false;
                    }
                } else {
                    return false;
                }
            }
        }
    }

    public static function generatePdf($pdfType, $propertyDetailsArray)
    {
        $pdfCreator = "Zeon Investments";
        $pdfAuthor  = "Zeon Investments";
        $loanCode   = $propertyDetailsArray['loan_code'] ?? 'ZAC';
        $pdfTitle   = "undefined pdf";


        if (isset(PDF_FILE_TYPE_ARRAY[$pdfType])) {

            // Extract data               
            $property_name  = $propertyDetailsArray['property_name'] ?? '';
            $property_name_prefix  = $propertyDetailsArray['property_name_prefix'] ?? '';
            $applicantName  = $propertyDetailsArray['applicant_name'] ?? '';
            $address        = $propertyDetailsArray['address'] ?? '';
            $unitClass      = $propertyDetailsArray['unit_class'] ?? '';
            $unitAmount     = $propertyDetailsArray['unit_amount'] ?? '';
            $totalAmount    = $propertyDetailsArray['total_amount'] ?? '';
            $appDate    = $propertyDetailsArray['app_date'] ?? '';
            $appMonthName    = $propertyDetailsArray['app_month_name'] ?? '';
            $appMonth   = $propertyDetailsArray['app_month'] ?? '';
            $appYearSuffix    = $propertyDetailsArray['app_year_suffix'] ?? '';
            $appYear    = $propertyDetailsArray['app_year'] ?? '';

            // Generate PDF based on type application_of_units
            if (strtolower(PDF_FILE_TYPE_ARRAY[$pdfType]) == 'application_of_units') {

                $pdfTitle   = "Application for Issue of Units " . $property_name;

                // PDF setup
                $pdf = new MyPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetCreator($pdfCreator);
                $pdf->SetAuthor($pdfAuthor);
                $pdf->SetTitle($pdfTitle);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetMargins(0, 0, 0);
                $pdf->AddPage();

                // Background form template
                $sourceFile = PDF_UPLOAD_PATH . 'source/application_of_units_source.pdf';
                $pagecount = $pdf->setSourceFile($sourceFile);
                $tplidx = $pdf->importPage(1);
                $pdf->useTemplate($tplidx, 0, 0, 210);

                // Font & text setup
                $pdf->SetFont('helvetica', '', 11);
                $pdf->SetTextColor(0, 0, 0);

                // === FIELD COORDINATES (mm) ===

                // trust name
                $pdf->SetFont('helvetica', 'B', 10);   // 'B' for bold
                // Measure text width
                $textWidth = $pdf->GetStringWidth(strtoupper($property_name_prefix)) - 16;
                $propertyPrefixX = 58; // Original X position
                // Center the text within the cell  
                $propertyPrefixX = $propertyPrefixX - $textWidth;


                $pdf->SetXY($propertyPrefixX, 49);      // shifted slightly right & down
                $pdf->Cell(0, 6, strtoupper($property_name_prefix), 0, 1);

                $pdf->SetFont('helvetica', 'B', 11);
                // 📝 Applicant Name ("I/We")
                $pdf->SetXY(40, 65);      // shifted slightly right & down
                //$pdf->Cell(130, 6, $applicantName, 0, 1);
                $pdf->MultiCell(130, 6, $applicantName, 0, 'L', false);

                // 🏠 Address ("Of")
                $pdf->SetXY(40, 78);      // adjusted down for better alignment with dash
                //$pdf->MultiCell(130, 6, $address, 0, 'L', false);
                $pdf->MultiCell(130, 6, $address, 0, 'L', false);

                // 🏷️ Unit Class ("Class of Units")
                $pdf->SetXY(85, 90);
                //$pdf->Cell(130, 6, $unitClass, 0, 1);
                $pdf->MultiCell(130, 6, $unitClass, 0, 'L', false);

                // 💰 Unit Amount ("Each unit will be fully paid...")
                $pdf->SetXY(105, 102);
                $pdf->Cell(0, 6, $totalAmount, 0, 1);

                // 💵 Total Amount ("I enclose my cheque...")
                $pdf->SetXY(86, 114);
                $pdf->Cell(0, 6, $totalAmount, 0, 1);

                // 📅 Date ("Dated")
                $pdf->SetXY(52, 135);
                $pdf->Cell(0, 6, $appDate, 0, 1);

                // month
                $pdf->SetXY(59, 135);
                $pdf->Cell(0, 6, $appMonth, 0, 1);

                //year
                $pdf->SetXY(67, 135);
                $pdf->Cell(0, 6, $appYearSuffix, 0, 1);

                //dated this
                $pdf->SetXY(45, 148);
                $pdf->Cell(0, 4, date('jS', mktime(0, 0, 0, 1, $appDate, 2025)), 0, 1);

                //day of
                $pdf->SetXY(92, 148);
                $pdf->Cell(0, 4, $appMonthName, 0, 1);

                //year
                $pdf->SetXY(148, 148);
                $pdf->Cell(0, 4, $appYearSuffix, 0, 1);

                // 👤 Full Name (Bottom Section)
                $pdf->SetXY(50, 171);
                //$pdf->Cell(0, 6, $applicantName, 0, 1);
                $pdf->MultiCell(130, 6, $applicantName, 0, 'L', false);

                // 🏡 Service Address (Bottom Section)
                $pdf->SetXY(50, 184);
                //$pdf->MultiCell(130, 6, $address, 0, 'L', false);
                $pdf->MultiCell(130, 6, $address, 0, 'L', false);
            }
            // Generate PDF based on type trust_account_authority
            elseif (strtolower(PDF_FILE_TYPE_ARRAY[$pdfType]) == 'trust_account_authority') {

                $pdfTitle   = "Trust Account Authority " . $property_name;

                // PDF setup
                $pdf = new MyPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetCreator($pdfCreator);
                $pdf->SetAuthor($pdfAuthor);
                $pdf->SetTitle($pdfTitle);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetMargins(0, 0, 0);
                $pdf->AddPage();

                // Background form template
                $sourceFile = PDF_UPLOAD_PATH . 'source/trust_account_authority_source.pdf';
                $pagecount = $pdf->setSourceFile($sourceFile);
                $tplidx = $pdf->importPage(1);
                $pdf->useTemplate($tplidx, 0, 0, 210);

                // Font & text setup
                $pdf->SetFont('helvetica', '', 11);
                $pdf->SetTextColor(0, 0, 0);

                // === FIELD COORDINATES (mm) ===

                //client details and address
                $pdf->SetFont('helvetica', '', 11);   // 'B' for bold
                $pdf->SetXY(40, 54);      // shifted slightly right & down
                $pdf->Cell(130, 8, $applicantName . " / " . $address, 0, 'L', false);

                //proerty name
                $pdf->SetFont('helvetica', '', 11);   // 'B' for bold
                $pdf->SetXY(45, 71);      // shifted slightly right & down
                $pdf->Cell(130, 6.5, $property_name, 0, 'L', false);

                //Client name
                $pdf->SetFont('helvetica', '', 11);   // 'B' for bold
                $pdf->SetXY(42, 77);      // shifted slightly right & down
                $pdf->Cell(130, 5, $applicantName, 0, 'L', false);

                // Draw the underline just below the text
                $pdf->SetLineWidth(0.1); // make line thicker
                $pdf->Line(23, 83, 194, 83);

                //Reference
                $pdf->SetFont('helvetica', 'B', 10);   // 'B' for bold
                $pdf->SetXY(67, 192);      // shifted slightly right & down
                $pdf->Cell(130, 6, $applicantName, 0, 'L', false);

                //Print name
                $pdf->SetFont('helvetica', 'B', 11);
                $pdf->SetXY(44, 216);      // shifted slightly right & down
                $pdf->Cell(130, 5, $applicantName, 0, 'L', false);

                //Print date
                $pdf->SetFont('helvetica', 'B', 11);
                $pdf->SetXY(44, 225);      // shifted slightly right & down
                $pdf->Cell(130, 5, $appDate . " / " . $appMonth . " / " . $appYear, 0, 'L', false);
            }
            // Generate PDF based on type trust_account_authority
            elseif (strtolower(PDF_FILE_TYPE_ARRAY[$pdfType]) == 'final_investment_deed') {

                $pdfTitle   = "Final Investment Deed " . $property_name;

                // PDF setup
                $pdf = new MyPDF('P', 'mm', 'A4', true, 'UTF-8', false);
                $pdf->SetCreator($pdfCreator);
                $pdf->SetAuthor($pdfAuthor);
                $pdf->SetTitle($pdfTitle);
                $pdf->setPrintHeader(false);
                $pdf->setPrintFooter(false);
                $pdf->SetMargins(0, 0, 0);


                // Background form template
                $sourceFile = PDF_UPLOAD_PATH . 'source/final_investment_deed_source.pdf';
                $pagecount = $pdf->setSourceFile($sourceFile);

                // Loop through each page of the source
                for ($pageNo = 1; $pageNo <= $pagecount; $pageNo++) {

                    $tplIdx = $pdf->importPage($pageNo);
                    $pdf->AddPage();
                    $pdf->useTemplate($tplIdx, 0, 0, 210);

                    // Optional: If you want to write dynamic text only on page 1
                    if ($pageNo === 1) {
                        $pdf->SetFont('helvetica', 'B', 11);
                        $pdf->SetXY(65, 39);
                        $pdf->Cell(130, 5, date('jS', mktime(0, 0, 0, 1, $appDate, 2025)) . " " . $appMonthName . " " . $appYear, 0, 'L', false);

                        $pdf->SetXY(25, 91);
                        $pdf->Cell(130, 5, $applicantName . " (" . $address . ")", 0, 'L', false);
                    }
                    if ($pageNo === 13) {
                        $pdf->SetXY(25, 43);
                        $pdf->Cell(130, 5, $applicantName, 0, 'L', false);

                        $pdf->SetXY(106, 43);
                        $pdf->Cell(130, 5, "$" . $totalAmount, 0, 'L', false);
                    }
                    if ($pageNo === 14) {
                        $pdf->SetFont('helvetica', 'B', 10);
                        $pdf->SetXY(130, 69);
                        $pdf->Cell(130, 6, date('jS', mktime(0, 0, 0, 1, $appDate, 2025)) . " " . $appMonthName . " " . $appYear, 0, 'L', false);
                    }
                }
            }

            // === OUTPUT ===
            $pdfTitleName = strtolower(str_replace(' ', '_', $pdfTitle));
            $newFileName = $pdfTitleName . "_" . $loanCode . ".pdf";
            $filePath = PDF_UPLOAD_PATH . $newFileName;

            //$pdf->Output('application_of_units.pdf', 'I');
            $pdf->Output($filePath, 'F'); // Save to server
            // $pdf->Output($newFileName, 'D'); // Uncomment to download directly

            return $newFileName;
        } else {
            return false;
        }
    }
}
