<!-- Contact Form -->
<form action="contacts/add.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="surname">Surname:</label>
    <input type="text" id="surname" name="surname" required>
    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>
    
    <!-- Additional fields for tabs -->
    <div class="tab">
        <!-- Client information tab -->
        <label>Client Information</label>
        <input type="text" id="client_name" name="client_name" required>
        <input type="text" id="client_code" name="client_code" readonly>
        <button type="submit">Save</button>
    </div>
</form>
<script src="js/script.js"></script>
