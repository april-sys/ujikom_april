<?php if (isset($_SESSION['user_id'])): ?>
        </main>

        <footer class="footer">
            Aplikasi Inventaris Data Barang &copy; <?= date('Y'); ?>
        </footer>
    </div>
</div>
<?php else: ?>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
