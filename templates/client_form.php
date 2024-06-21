<!-- Client Form -->
<form action="../clients/add.php" method="POST">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required>
    <label for="client_code">Client Code:</label>
    <input type="text" id="client_code" name="client_code" readonly>
    
    <!-- Additional fields for tabs -->
    <div class="tab">
        <!-- Contact information tab -->
        <label>Contact Information</label>
        <input type="text" id="contact_name" name="contact_name" required>
        <input type="email" id="contact_email" name="contact_email" required>
        <button type="submit">Save</button>
    </div>
</form>
<script src="../js/script.js"></script>
