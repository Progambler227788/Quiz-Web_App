   // Toggle Menu
   document.addEventListener('DOMContentLoaded', function () {

    const profileDropdown = document.getElementById('profileDropdown');
    const dropdownMenu = document.getElementById('dropdownMenu');

    profileDropdown.addEventListener('click', function (e) {
      e.preventDefault(); // this function helps to prevent our page going to another page using href disabling
      dropdownMenu.classList.toggle('show');
    });

    // Close the dropdown if clicked outside
    // toggle is a method, that disable or enable class of show on clciking, classList are classes of element
    document.addEventListener('click', function (e) {
      if (!profileDropdown.contains(e.target)) {
        dropdownMenu.classList.remove('show'); 
      }
    });
  });
// function to move to login page
function moveToLogin(){
         location.href = 'login.php'
        
}