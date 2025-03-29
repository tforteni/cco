<script>
    document.addEventListener("DOMContentLoaded", function () {
        const modal = document.getElementById('successModal');
        if (modal) {
            modal.style.display = 'flex';
            setTimeout(() => { closeModal(); }, 3000);
        }

        const roleDropdown = document.getElementById('role');
        if (roleDropdown) {
            roleDropdown.addEventListener('change', function () {
                const braiderFields = document.getElementById('braider-fields');
                if (this.value === 'braider') {
                    braiderFields.classList.remove('hidden');
                } else {
                    braiderFields.classList.add('hidden');
                }
            });
        }
    });

    function closeModal() {
        const modal = document.getElementById('successModal');
        if (modal) modal.style.display = 'none';
    }
</script>
