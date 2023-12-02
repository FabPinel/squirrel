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

$(document).ready(function () {
    // Fonction pour afficher la pop-up edit
    function showEditProfilePopup() {
        var popup = $('#editProfilePopup');
        popup.show();
    }

    // Ajoutez un gestionnaire d'événements au bouton "Editer le profil"
    var editProfileButton = $('.profilEdit');
    editProfileButton.on('click', showEditProfilePopup);
});

// Fonction pour fermer la pop-up
function hideEditProfilePopup() {
    var popup = $('#editProfilePopup');
    popup.hide();
}