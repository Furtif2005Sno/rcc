document.addEventListener('DOMContentLoaded', function() {
    const birthdateElement = document.getElementById('birthdate');
    const ageElement = document.getElementById('age');
    
    if (birthdateElement && ageElement) {
        const birthdate = new Date('2005-05-29'); // Remplace avec ta date exacte
        const today = new Date();
        let age = today.getFullYear() - birthdate.getFullYear();
        const monthDiff = today.getMonth() - birthdate.getMonth();

        if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
            age--;
        }

        ageElement.innerHTML = `${age} ans`; // Ajoute un espace après l'âge
    }
});
