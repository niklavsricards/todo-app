<?php require_once 'app/Views/partials/header.template.php'; ?>

<h1> Users </h1>

<table class="table table-striped w-25 m-3">
    <thead>
    <tr>
        <th>Id: </th>
        <th>Name: </th>
    </tr>
    </thead>
    <tbody>
        <?php foreach($users->getUsers() as $user): ?>
            <tr>
                <td><?php echo $user->getId() ?></td>
                <td><?php echo $user->getName() ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>