<!-- Client List -->
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Client Code</th>
            <th>No. of Linked Contacts</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($clients as $client): ?>
        <tr>
            <td><?= $client['name'] ?></td>
            <td><?= $client['client_code'] ?></td>
            <td><?= $client['linked_contacts'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>
