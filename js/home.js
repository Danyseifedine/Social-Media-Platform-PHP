// Function to add a new post
function addNewPost() {
  // Create the new post element
  const newPost = document.createElement('div');
  newPost.classList.add('post');

  // Create the heart element for the new post
  const heart = document.createElement('div');
  heart.classList.add('heart');
  heart.classList.add('white'); // Set the default color as white
  newPost.appendChild(heart);

  // Add the new post to the DOM

  // Add event listener to the heart element
  heart.addEventListener('click', () => {
    heart.classList.toggle('red');
    const heartId = `heartColor${index}`; // Unique identifier for each heart
    if (heart.classList.contains('red')) {
      localStorage.setItem(heartId, 'red');
    } else {
      localStorage.removeItem(heartId);
    }
  });

}






var menuButtons = document.querySelectorAll('.menu-button');
var backButtons = document.querySelectorAll('.back-button');

menuButtons.forEach(function (menuButton) {
    menuButton.addEventListener('click', function () {
        var menuCard = this.closest('.post-home-card').querySelector('.menu-opt');
        menuCard.classList.toggle('show');
    });
});

backButtons.forEach(function (backButton) {
    backButton.addEventListener('click', function () {
        var menuCard = this.closest('.menu-opt');
        menuCard.classList.remove('show');
    });
});




