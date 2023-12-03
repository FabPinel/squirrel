(function () {
    $(function () {
        var toggle;
        return toggle = new Toggle('.toggle');
    });

    this.Toggle = (function () {
        Toggle.prototype.el = null;

        Toggle.prototype.tabs = null;

        Toggle.prototype.panels = null;

        function Toggle(toggleClass) {
            this.el = $(toggleClass);
            this.tabs = this.el.find(".tab");
            this.panels = this.el.find(".panel");
            this.bind();
        }

        Toggle.prototype.show = function (index) {
            var activePanel, activeTab;
            this.tabs.removeClass('active');
            activeTab = this.tabs.get(index);
            $(activeTab).addClass('active');
            this.panels.hide();
            activePanel = this.panels.get(index);
            return $(activePanel).show();
        };

        Toggle.prototype.bind = function () {
            var _this = this;
            return this.tabs.unbind('click').bind('click', function (e) {
                return _this.show($(e.currentTarget).index());
            });
        };

        return Toggle;

    })();

}).call(this);

//Fonction pour ouvrir et fermer la pop up edit profil
$(document).ready(function () {
    function showEditProfilePopup() {
        var popup = $('#editProfilePopup');
        var overlay = $('#overlay');

        popup.show();
        overlay.show();
    }

    var editProfileButton = $('.profilEdit');
    editProfileButton.on('click', showEditProfilePopup);

    function hideEditProfilePopup() {
        var popup = $('#editProfilePopup');
        var overlay = $('#overlay');

        popup.hide();
        overlay.hide();
    }

    var closeButton = $('.closeButton');
    closeButton.on('click', hideEditProfilePopup);

    var overlay = $('#overlay');
    overlay.on('click', hideEditProfilePopup);
});

//Fonction Like
$(document).on('click', '.like-button', function () {
    var postId = $(this).parent().data('post-id');
    var userId = $(this).parent().data('user-id');

    var likeButton = $(this);
    var likePost = likeButton.closest('.likePost');
    var likeCountElement = likePost.find('.like-count');

    console.log("postId:", postId);
    console.log("userId:", userId);

    $.ajax({
        url: '../controller/profilController.php',
        method: 'POST',
        data: { postId: postId, userId: userId, action: 'toggleLike' },
        success: function (response) {
            var jsonResponse = JSON.parse(response);
            console.log("AJAX Response:", jsonResponse);
            console.log("Likes Count:", jsonResponse.likesCount);

            likeButton.css('color', jsonResponse.isLiked ? 'red' : 'black');

            // Ajoutez ou supprimez la classe 'like-active' en fonction de l'état du like
            likePost.toggleClass('like-active', jsonResponse.isLiked);

            updateLikeCount(jsonResponse.likesCount, likeCountElement);
        },

        error: function () {
            console.log('Erreur lors de la requête AJAX');
        }
    });
});

// Fonction de rappel pour mettre à jour le nombre de likes
function updateLikeCount(likesCount, likeCountElement) {
    likeCountElement.text(likesCount);
    console.log("Updated Likes Count:", likesCount);
}
