// fonction toggle tab
(function () {
    $(function () {
        var toggle;
        toggle = new Toggle('.toggle');
        toggle.show(0);
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
            $(activePanel).show();
        };

        Toggle.prototype.bind = function () {
            var _this = this;
            this.el.on('click', '.tab', function (e) {
                return _this.show($(e.currentTarget).index());
            });
        };

        return Toggle;

    })();

}).call(this);


const modal = document.querySelector('.modal');
const overlay = document.querySelector('.overlay');
const btnCloseModal = document.querySelector('.close-modal');
const btnsOpenModal = document.querySelectorAll('.show-modal');

const openModal = function () {
    modal.classList.remove('hidden');
    overlay.classList.remove('hidden');
};

const closeModal = function () {
    modal.classList.add('hidden');
    overlay.classList.add('hidden');
};

for (let i = 0; i < btnsOpenModal.length; i++)
    btnsOpenModal[i].addEventListener('click', openModal);

btnCloseModal.addEventListener('click', closeModal);
overlay.addEventListener('click', closeModal);

document.addEventListener('keydown', function (event) {
    console.log(event.key);

    if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
        closeModal();
    }
});