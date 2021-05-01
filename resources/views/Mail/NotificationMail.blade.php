
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

<h2>Course Details </h2>

<table>
  <tr>
    <th>Course Name</th>
    <th>Type</th>
    <th>assigned Date</th>

  </tr>
  @foreach($studentcourse as $studentcourse1)
         @foreach($studentcourse1 as $studentcourse2)
           <tr>
           <td>{{$studentcourse2->course_name}}</td>
           <td>{{$studentcourse2->type}}</td>
            <td>{{$studentcourse2->date}}</td>
          </tr>
         @endforeach
         @endforeach

</table>

</body>
</html>