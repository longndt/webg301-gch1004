<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Book Detail</title>
   <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
</head>
<body>
<div class="container col-md-8 text-center mt-3">
   <h2 class="alert alert-success"><?= $book->title ?></h2>
   <div class="row">
      <div class="col">
          <img src="<?= $book->image ?>" width="250" height="250">  
      </div>
      <div class="col">
         <h5 class="text text-primary">Book Author: <?= $book->author ?></h5>
         <h5 class="text text-warning">Book Price: <?= $book->price ?> $ </h5>
      </div>
   </div>
</div>
</body>
</html>