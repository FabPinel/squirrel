document.addEventListener("DOMContentLoaded", function () {
    const uls = document.querySelectorAll("ul");

    uls.forEach((ul) => {
        const resetClass = ul.parentNode.getAttribute("class");
        const lis = ul.querySelectorAll("li");

        lis.forEach((li) => {
            li.addEventListener("click", (e) => {
                e.preventDefault();
                e.stopPropagation();
                const target = e.currentTarget;

                if (
                    target.classList.contains("active") ||
                    target.classList.contains("follow")
                ) {
                    return;
                }

                lis.forEach((item) => clearClass(item, "active"));

                setClass(target, "active");

                const pageUrl = target.querySelector("a").getAttribute("href");
                console.log("Redirecting to:", pageUrl);

                // Redirection vers la nouvelle page
                window.location.href = pageUrl;
            });
        });
    });

    function clearClass(node, className) {
        node.classList.remove(className);
    }

    function setClass(node, className) {
        node.classList.add(className);
    }
});
