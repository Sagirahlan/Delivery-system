/**
 * SwiftDrop — Client-side interactivity
 */

document.addEventListener('DOMContentLoaded', () => {
    initMobileMenu();
    initRoleTabs();
    initRegisterSteps();
    initOrderSteps();
    initOrderForm();
    initCountdown();
    initAvailabilityToggle();
    initStatusButtons();
    initAdminSidebar();
});

/* ===== MOBILE MENU ===== */
function initMobileMenu() {
    const btn = document.getElementById('mobile-menu-btn');
    const menu = document.getElementById('mobile-menu');
    if (!btn || !menu) return;

    btn.addEventListener('click', () => {
        menu.classList.toggle('hidden');
        const icon = btn.querySelector('i');
        if (menu.classList.contains('hidden')) {
            icon.className = 'ph-bold ph-list text-xl text-[var(--color-text-primary)]';
        } else {
            icon.className = 'ph-bold ph-x text-xl text-[var(--color-text-primary)]';
        }
    });
}

/* ===== LOGIN ROLE TABS ===== */
function initRoleTabs() {
    const tabs = document.querySelectorAll('#login-role-tabs .role-tab');
    if (!tabs.length) return;

    tabs.forEach(tab => {
        tab.addEventListener('click', () => {
            tabs.forEach(t => t.classList.remove('active'));
            tab.classList.add('active');
        });
    });
}

/* ===== REGISTER MULTI-STEP ===== */
function initRegisterSteps() {
    // Make goToStep globally available
    window.goToStep = function(step) {
        const steps = document.querySelectorAll('.form-step');
        const dots = document.querySelectorAll('#register-steps .step-dot');
        const lines = document.querySelectorAll('#register-steps .step-line');
        if (!steps.length) return;

        // Update review panel on step 3
        if (step === 3) {
            const name = document.getElementById('reg-name');
            const email = document.getElementById('reg-email');
            const phone = document.getElementById('reg-phone');
            const role = document.querySelector('input[name="role"]:checked');

            if (name) document.getElementById('review-name').textContent = name.value || '—';
            if (email) document.getElementById('review-email').textContent = email.value || '—';
            if (phone) document.getElementById('review-phone').textContent = phone.value || '—';
            if (role) document.getElementById('review-role').textContent = role.value || '—';
        }

        steps.forEach(s => s.classList.add('hidden'));
        const target = document.getElementById(`register-step-${step}`);
        if (target) {
            target.classList.remove('hidden');
            target.classList.add('animate-fade-in-up');
        }

        // Update dots
        dots.forEach((dot, i) => {
            dot.classList.remove('active', 'completed');
            if (i + 1 < step) dot.classList.add('completed');
            if (i + 1 === step) dot.classList.add('active');
        });

        // Update lines
        lines.forEach((line, i) => {
            line.classList.toggle('completed', i + 1 < step);
        });
    };
}

/* ===== ORDER MULTI-STEP ===== */
function initOrderSteps() {
    window.goToOrderStep = function(step) {
        const steps = document.querySelectorAll('.order-step');
        const dots = document.querySelectorAll('#order-steps .step-dot');
        const lines = document.querySelectorAll('#order-steps .step-line');
        if (!steps.length) return;

        // Update review on step 3
        if (step === 3) updateOrderReview();

        steps.forEach(s => s.classList.add('hidden'));
        const target = document.getElementById(`order-step-${step}`);
        if (target) {
            target.classList.remove('hidden');
            target.classList.add('animate-fade-in-up');
        }

        dots.forEach((dot, i) => {
            dot.classList.remove('active', 'completed');
            if (i + 1 < step) dot.classList.add('completed');
            if (i + 1 === step) dot.classList.add('active');
        });

        lines.forEach((line, i) => {
            line.classList.toggle('completed', i + 1 < step);
        });

        window.scrollTo({ top: 0, behavior: 'smooth' });
    };
}

/* ===== ORDER FORM LIVE UPDATE ===== */
function initOrderForm() {
    // Live summary update
    const pickupField = document.getElementById('pickup-address');
    const deliveryField = document.getElementById('delivery-address');
    const packageField = document.getElementById('package-desc');
    const fragileCheck = document.getElementById('fragile-check');
    const sizeRadios = document.querySelectorAll('input[name="package-size"]');

    if (pickupField) {
        pickupField.addEventListener('input', () => {
            const el = document.getElementById('summary-from');
            if (el) el.textContent = pickupField.value || 'Enter pickup address';
        });
    }

    if (deliveryField) {
        deliveryField.addEventListener('input', () => {
            const el = document.getElementById('summary-to');
            if (el) el.textContent = deliveryField.value || 'Enter delivery address';
        });
    }

    if (packageField) {
        packageField.addEventListener('input', () => {
            const el = document.getElementById('summary-package');
            if (el) el.textContent = packageField.value || '—';
        });
    }

    sizeRadios.forEach(radio => {
        radio.addEventListener('change', updateSummaryPrice);
    });

    if (fragileCheck) {
        fragileCheck.addEventListener('change', updateSummaryPrice);
    }

    // Prevent default form submit for placeholder order form
    const form = document.getElementById('place-order-form');
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault();
            // Simulate success
            alert('Order placed successfully! Your order ID is #SD-' + Math.floor(1000 + Math.random() * 9000));
            window.location.href = '/dashboard/customer';
        });
    }
}

function updateSummaryPrice() {
    const sizeSelected = document.querySelector('input[name="package-size"]:checked');
    const fragile = document.getElementById('fragile-check');
    const prices = { small: 500, medium: 1000, large: 2000 };
    const serviceFee = 100;

    let base = sizeSelected ? prices[sizeSelected.value] : 500;
    let fragileAmount = fragile && fragile.checked ? 200 : 0;
    let total = base + fragileAmount + serviceFee;

    // Update sidebar
    const sizeEl = document.getElementById('summary-size');
    if (sizeEl) sizeEl.textContent = sizeSelected ? sizeSelected.value : 'Small';

    const priceEl = document.getElementById('summary-price');
    if (priceEl) priceEl.textContent = '₦' + total.toLocaleString();

    const fragileRow = document.getElementById('summary-fragile-row');
    if (fragileRow) fragileRow.style.display = fragile && fragile.checked ? 'flex' : 'none';
}

function updateOrderReview() {
    const pickup = document.getElementById('pickup-address');
    const delivery = document.getElementById('delivery-address');
    const pkg = document.getElementById('package-desc');
    const sizeSelected = document.querySelector('input[name="package-size"]:checked');
    const fragile = document.getElementById('fragile-check');
    const prices = { small: 500, medium: 1000, large: 2000 };
    const serviceFee = 100;

    if (pickup) {
        const el = document.getElementById('review-pickup');
        if (el) el.textContent = pickup.value || '—';
    }
    if (delivery) {
        const el = document.getElementById('review-delivery');
        if (el) el.textContent = delivery.value || '—';
    }
    if (pkg) {
        const el = document.getElementById('review-package');
        if (el) el.textContent = pkg.value || '—';
    }
    if (sizeSelected) {
        const el = document.getElementById('review-size');
        if (el) el.textContent = sizeSelected.value;
    }

    let base = sizeSelected ? prices[sizeSelected.value] : 500;
    let fragileAmount = fragile && fragile.checked ? 200 : 0;
    let total = base + fragileAmount + serviceFee;

    const baseEl = document.getElementById('review-base');
    if (baseEl) baseEl.textContent = '₦' + base.toLocaleString();

    const fragileRow = document.getElementById('review-fragile-row');
    if (fragileRow) fragileRow.style.display = fragile && fragile.checked ? 'flex' : 'none';

    const totalEl = document.getElementById('review-total');
    if (totalEl) totalEl.textContent = '₦' + total.toLocaleString();
}

/* ===== COUNTDOWN TIMER ===== */
function initCountdown() {
    const timer = document.getElementById('countdown-timer');
    if (!timer) return;

    let minutes = 12;
    let seconds = 0;

    setInterval(() => {
        if (seconds === 0) {
            if (minutes === 0) return;
            minutes--;
            seconds = 59;
        } else {
            seconds--;
        }
        timer.textContent = `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
    }, 1000);
}

/* ===== AVAILABILITY TOGGLE ===== */
function initAvailabilityToggle() {
    const toggle = document.getElementById('availability-toggle');
    const label = document.getElementById('availability-label');
    if (!toggle || !label) return;

    toggle.addEventListener('click', () => {
        toggle.classList.toggle('active');
        if (toggle.classList.contains('active')) {
            label.textContent = 'Online';
            label.className = 'text-sm font-semibold text-[var(--color-success)]';
        } else {
            label.textContent = 'Offline';
            label.className = 'text-sm font-semibold text-[var(--color-text-muted)]';
        }
    });
}

/* ===== AGENT STATUS BUTTONS ===== */
function initStatusButtons() {
    const btnTransit = document.getElementById('btn-transit');
    const btnDelivered = document.getElementById('btn-delivered');
    if (!btnTransit || !btnDelivered) return;

    btnTransit.addEventListener('click', () => {
        btnTransit.disabled = true;
        btnTransit.classList.add('opacity-50', 'cursor-not-allowed');
        btnTransit.innerHTML = '<i class="ph-bold ph-check"></i> Marked In Transit';
        btnDelivered.classList.remove('btn-outline');
        btnDelivered.classList.add('btn-success');
    });

    btnDelivered.addEventListener('click', () => {
        btnDelivered.disabled = true;
        btnDelivered.classList.add('opacity-50', 'cursor-not-allowed');
        btnDelivered.innerHTML = '<i class="ph-bold ph-check-circle"></i> Delivered!';

        // Visual feedback
        const card = document.getElementById('active-delivery');
        if (card) {
            card.classList.remove('border-[var(--color-orange-primary)]/30', 'glow-orange');
            card.classList.add('border-[var(--color-success)]/30');
        }
    });
}

/* ===== ADMIN SIDEBAR ===== */
function initAdminSidebar() {
    const toggle = document.getElementById('admin-sidebar-toggle');
    const sidebar = document.getElementById('admin-sidebar');
    if (!toggle || !sidebar) return;

    toggle.addEventListener('click', () => {
        sidebar.classList.toggle('open');
    });

    // Close on click outside (mobile)
    document.addEventListener('click', (e) => {
        if (window.innerWidth < 1024 && sidebar.classList.contains('open')) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });

    // Sidebar link active state
    const sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(link => {
        link.addEventListener('click', (e) => {
            if (link.getAttribute('href') === '#') {
                e.preventDefault();
                sidebarLinks.forEach(l => l.classList.remove('active'));
                link.classList.add('active');
            }
        });
    });
}
