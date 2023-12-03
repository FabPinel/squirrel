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
