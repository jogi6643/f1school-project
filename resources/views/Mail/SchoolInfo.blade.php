
<style>
table {
  font-family: arial, sans-serif;
  border-collapse: collapse;
  width: 100%;
}

td, th {
  border: 1px solid #dddddd;
  text-align: left;
  padding: 8px;
}

tr:nth-child(even) {
  background-color: #dddddd;
}
</style>
</head>
<body>

<h2>School Details</h2>

<table>
  <tr>
    <th>School Name</th>
    <th>Zone</th>
    <th>City</th>
     <th>Mobile</th>
       <th>Website</th>

  </tr>

         @foreach($Schoolinfo as $Schoolinfo1)
           <tr>
           <td>{{$Schoolinfo1->school_name}}</td>
           <td>{{$Schoolinfo1->zone}}</td>
            <td>{{$Schoolinfo1->name}}</td>
             <td>{{$Schoolinfo1->mobile}}</td>
              <td>{{$Schoolinfo1->website}}</td>
          </tr>
    
         @endforeach

</table>

</body>
</html>