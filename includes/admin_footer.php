</div>
</div>
</div>

<footer class="main-footer" style="text-align:center; padding:1rem; background:#f5f5f5; border-top:1px solid #ddd;">
    <p class="copyright-text" style="margin:0;">
        &copy; <span id="year"></span> VoteXpress — All Rights Reserved
    </p>
</footer>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Dynamic year for copyright
        document.getElementById("year").textContent = new Date().getFullYear();

        // Highlight active link
        const currentPage = window.location.pathname.split("/").pop();
        document.querySelectorAll('.sidebar-menu .sidebar-link').forEach(link => {
            link.classList.toggle('active', link.getAttribute('href') === currentPage);
        });
    });
</script>

</body>

</html>