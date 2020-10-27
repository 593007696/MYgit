<!DOCTYPE html>
<html>

<head>
  <style>
    .scrollTable {
      width: 830px;
      border: 5px solid red;
    }


    .scrollTable table {
      border-collapse: collapse;

    }

    .scrollTable .thead {

      width: 100%;


    }

    .scrollTable .thead th {
      /*表头*/
      color: #fff;
      background: #FF8C00;
      width: 200px;

      border-left: 1px solid white;

    }

    .scrollTable .tbody {

      width: 100%;

      height: 200px;
      overflow: auto;

      background: #ECE9D8;
      color: #666666;


    }

    .scrollTable .tbody td {

      width: 200px;
      border-left: 1px solid orange;
      border-top: 1px solid orange;
    }

    .scrollTable ::-webkit-scrollbar {
      width: 20px;
      background-color: white;
    }


    .scrollTable ::-webkit-scrollbar-track {
      
      border-radius: 100px;
      background-color: #F5F5F5;
      box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
    }

    .scrollTable ::-webkit-scrollbar-thumb {
      border-radius: 100px;
      box-shadow: inset 0 0 6px rgba(0, 0, 0, .3);
      background-color: #555;
    }
  </style>





</head>

<body>
  <div class="scrollTable">

    <div class="thead">
      <table>
        <tbody>
          <tr>
            <th>1</th>
            <th>2</th>
            <th>3</th>
            <th>4</th>
          </tr>
        </tbody>
      </table>
    </div>

    <div class="tbody">
      <table>
        <tbody>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
          <tr>
            <td>q</td>
            <td>a</td>
            <td>z</td>
            <td>w</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>


</body>

</html>