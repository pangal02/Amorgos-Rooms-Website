<script>
    document.getElementById('reservationForm').addEventListener('submit', function(event) {

        // Ελέγχος της φόρμας πριν την υποβολή
        if (!validateForm()) {
            return;
        }

        // Αν όλα τα πεδία είναι έγκυρα, αποστολή της φόρμας
        this.submit();
    });

    function validateForm() {
        var name = document.getElementById('name').value;
        var surname = document.getElementById('surname').value;
        var email = document.getElementById('email').value;
        var phone = document.getElementById('phone').value;
        var arrivalDate = document.getElementById('arrivalDate').value;
        var departureDate = document.getElementById('departureDate').value;

        // Ελέγχος για το όνομα και το επίθετο
        if (name.length < 2 || surname.length < 2) {
            alert('Το όνομα και το επίθετο πρέπει να έχουν τουλάχιστον 2 χαρακτήρες.');
            return false;
        }

        // Ελέγχος για το email
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            alert('Παρακαλώ εισάγετε ένα έγκυρο email.');
            return false;
        }

        // Ελέγχος για το τηλέφωνο
        var phonePattern = /^[0-9]{10,15}$/;
        if (!phonePattern.test(phone)) {
            alert('Το τηλέφωνο πρέπει να αποτελείται από 10 έως 15 ψηφία.');
            return false;
        }

        // Ελέγχος για τις ημερομηνίες άφιξης και αναχώρησης
        var currentDate = new Date().toISOString().split('T')[0];
        if (arrivalDate < currentDate) {
            alert('Η ημερομηνία άφιξης δεν μπορεί να είναι προγενέστερη από την τρέχουσα ημερομηνία.');
            return false;
        }
        if (departureDate <= arrivalDate) {
            alert('Η ημερομηνία αναχώρησης πρέπει να είναι μεταγενέστερη από την ημερομηνία άφιξης.');
            return false;
        }

        return true;
    }
</script>