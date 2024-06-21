<!-- Contact List -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Surname</th>
            <th>Email</th>
            <th>No. of Linked Clients</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($contacts as $contact): ?>
        <tr>
            <td><?= $contact['name'] ?></td>
            <td><?= $contact['surname'] ?></td>
            <td><?= $contact['email'] ?></td>
            <td><?= $contact['linked_clients'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
