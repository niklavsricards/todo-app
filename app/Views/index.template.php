<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>To Do List App</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
</head>
<body>
    <!--<a class="btn btn-primary m-3" href="/todos/create">Create a new to do</a>-->
    <h3 class="m-3">Create a new To Do:</h3>

    <form class="m-3 w-25" action="/todos/create" method="post">
        <div class="form-group">
            <label for="email">What is your task?</label>
            <input type="text" name="toDoText" class="form-control" placeholder="Enter your to-do task">
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    <h3 class="m-3">To do list:</h3>

    <table class="table table-striped w-50 m-3">
        <thead>
            <tr>
                <th>#</th>
                <th>To Do: </th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($toDoItems->getToDoItems() as $key => $item): ?>
                <tr>
                    <td><?php echo $key + 1 ?></td>
                    <td><?php echo $item->getTodo() ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>
