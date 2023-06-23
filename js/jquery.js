$(document).ready(function () {
  // Get the user ID or username, whichever is unique and identifies the user
  var userId = "<?php echo $_SESSION['userId']; ?>";
  
  // Retrieve liked post IDs from the local storage
  var likedPosts = JSON.parse(localStorage.getItem(userId)) || [];

  // Function to update the like count
  function updateLikeCount(commentId, button) {
    // Send an AJAX request to update the like count
    $.ajax({
      url: "http://university.test/full_project/db.config/like.inc.php",
      method: "POST",
      data: { commentId: commentId },
      success: function (response) {
        // Update the like count on the page
        var likeCountElement = button.closest('.description-post').find('.likeCount');
        var likeCount = parseInt(response, 10);
        
        if (isNaN(likeCount)) {
          // Handle parsing error or assign a fallback value
          likeCount = 0;
        }
        
        likeCountElement.text(likeCount);
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.error("Update like count AJAX request failed:", textStatus, errorThrown);
      }
    });
  }

  // Attach click event to the like button
  $(document).on("click", ".likeButton", function () {
    var commentId = $(this).data("comment-id");
    var button = $(this);

    // Check if the comment ID is already liked
    if (likedPosts.includes(commentId)) {
      // Remove the comment ID from liked posts
      likedPosts = likedPosts.filter(function (postId) {
        return postId !== commentId;
      });

      // Update the heart icon style
      button.removeClass("liked");
    } else {
      // Add the comment ID to liked posts
      likedPosts.push(commentId);

      // Update the heart icon style
      button.addClass("liked");
    }

    // Update the liked post IDs in the local storage
    localStorage.setItem(userId, JSON.stringify(likedPosts));

    // Update the like count
    updateLikeCount(commentId, button);
  });

  // Load the initial like states for the user
  $(".likeButton").each(function () {
    var commentId = $(this).data("comment-id");

    // Check if the comment ID is in the liked posts array
    if (likedPosts.includes(commentId)) {
      $(this).addClass("liked");
    }
  });
});
