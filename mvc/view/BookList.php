<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book List</title>
   <!-- Bootstrap -->
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
   <style>
      body {
         background-color: skyblue;
      }
      img {
         border-radius: 50%;
      }
   </style>
</head>
<body>
<div class="container col-md-8 text-center mt-4">
   <h1 class="text text-danger">Book List</h1>
   <table class="table table-success">
      <thead>
         <tr>
            <th>Book Title</th>
            <th>Book Image</th>
            <th>Action</th>
         </tr>
      </thead>
      <tbody>
          <?php 
          foreach ($bookList as $book) { 
          ?>
            <tr>
               <td> <?= $book->title ?> </td>
               <td> 
                  <img src="<?=$book->image ?>" width="100" height="100">   
               </td>
               <td>
                  <a class="btn btn-warning">Detail</a>
               </td>
            </tr>
          <?php   
            }
          ?>
      </tbody>
   </table>
</div>
</body>
</html>