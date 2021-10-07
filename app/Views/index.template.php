<?php require_once 'app/Views/partials/header.template.php'; ?>

    <h3 class="m-3">Create a new To Do:</h3>

    <form class="m-3 w-25" action="/todos/create" method="post">
        <div class="form-group">
            <label for="email">What is your task?</label>
            <input type="text" name="title" class="form-control" placeholder="Enter your to-do task">
        </div>

        <button type="submit" name="submit" class="btn btn-primary mt-3">Submit</button>
    </form>

    <h3 class="m-3">To do list:</h3>

    <table class="table table-striped w-25 m-3">
        <thead>
            <tr>
                <th>To Do: </th>
                <th>Completed</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($toDoItems->getToDoItems() as $item): ?>
                <tr>
                    <td><?php echo $item->getTitle() ?></td>
                    <td>
                        <form action="/todos/<?php echo $item->getId() ?>" method="post">
                            <button type="submit" class="btn btn-primary">Completed</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once 'app/Views/partials/footer.template.php';
