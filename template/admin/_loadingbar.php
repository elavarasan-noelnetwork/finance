<?php 
/* ======================================
  Filename: Loading bar
  Author: Elavarasan 
  Description: Top Nav bar
  =======================================
*/
?>
<style>
  .dataTables_processing.card {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);  
      z-index: 9999;                   
      display: flex;
      align-items: center;
      justify-content: center;
  }

  div.dataTables_processing {
      position: absolute;
      top: 50%;
      left: 50%;
      width: 200px;
      margin-left: 0px;
      margin-top: 0px;
      /* text-align: center; */
      padding: 2px;
      z-index: 10;
  }

  div.dataTables_processing > div:last-child {
      position: relative;
      width: 38%;
      height: 42px;
      margin: 0em auto;
      background: #fff;
      /* padding: 13px; */
      /* border-radius: 5px; */
      padding-left: 32%;
      text-align: center;
      margin-left: 31%;
      border-radius: 0px 0px 5px 5px;
  }

  div.dataTables_processing > div:last-child > div {
      position: absolute;
      top: 16px;
      width: 13px;
      height: 13px;
      border-radius: 50%;
      background: #3ec3bd;
      /* background: rgb(var(--dt-row-selected)); */
      animation-timing-function: cubic-bezier(0, 1, 1, 0);
      margin-left: 45%;
  }

  .loading-content {
      width: 38%;
      background: #fff;
      border-radius: 5px 5px 0px 0px;
      padding: 10px 10px 10px 10px;
      font-size: 17px;
      border: 1px solid #c5c0c0;
  }
</style>


<div class="dataTables_processing card loading hide" role="status" >
  <div class="loading-content ">Loading Content </div>
  <div><div>
  </div><div>
  </div><div>
  </div><div>
  </div></div>
</div>