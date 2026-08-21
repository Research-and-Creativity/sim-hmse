import { test, expect } from '@playwright/test';

test.describe('E2E SIM HMSE - Role Switching & Menu Scanning', () => {
    // Jalankan aplikasi di localhost:8000
    const baseURL = 'http://127.0.0.1:8000';

    test('Harus bisa login sebagai Guest, ganti role ke President, dan buka semua menu tanpa error', async ({ page }) => {
        
        // 1. Buka halaman utama aplikasi
        console.log('Membuka halaman utama...');
        await page.goto(baseURL);
        await expect(page).toHaveTitle(/SIM HMSE|Laravel/i); // Sesuaikan dengan title yang ada

        // 2. Simulasi login menggunakan role Guest/Tamu
        console.log('Navigasi ke halaman login...');
        await page.goto(`${baseURL}/login`);
        
        console.log('Login sebagai Guest...');
        // Mengisi form login
        await page.fill('input[type="email"], input[name="email"]', 'guest@example.com');
        await page.fill('input[type="password"], input[name="password"]', 'password'); // Sesuaikan credential
        await page.click('button[type="submit"]');

        // Memastikan berhasil login ke dashboard Guest
        // (menyesuaikan dengan path default Filament)
        await page.waitForURL('**/dashboard*');
        
        // 3. Navigasi atau pergantian role dari Guest ke role 'President'
        console.log('Mengganti role ke President (Ketua/Admin)...');
        // Jika penggantian role ini butuh logout lalu login akun lain:
        
        // Logout
        await page.goto(`${baseURL}/logout`); 
        
        // Login kembali sebagai President
        await page.goto(`${baseURL}/login`);
        await page.fill('input[type="email"], input[name="email"]', 'president@example.com');
        await page.fill('input[type="password"], input[name="password"]', 'password');
        await page.click('button[type="submit"]');
        
        await page.waitForURL('**/dashboard*');
        console.log('Berhasil login sebagai President.');

        // 4. Lakukan scanning dan klik pada semua menu fitur utama di dashboard
        console.log('Memulai scanning menu utama...');
        
        // Daftar URL/menu utama berdasarkan fitur SIM HMSE (disesuaikan dengan route asli aplikasi)
        const menus = [
            '/dashboard',                  // Dashboard Overview
            '/dashboard/proker',           // Program Kerja
            '/dashboard/proposal',         // Proposal Kegiatan
            '/dashboard/finance',          // Keuangan
            '/dashboard/sotk',             // SOTK (Struktur Organisasi)
            '/dashboard/events',           // Events
            '/dashboard/documents',        // Dokumentasi
            '/dashboard/settings',         // Pengaturan
        ];

        for (const menuUrl of menus) {
            console.log(`Menguji menu: ${menuUrl}`);
            const response = await page.goto(`${baseURL}${menuUrl}`);
            
            // Memastikan tidak ada halaman yang error (404/500)
            expect(response.status(), `Halaman ${menuUrl} mengembalikan status ${response.status()}`).toBeLessThan(400);

            // Memastikan halaman memiliki body dan tidak menampilkan pesan error
            const pageText = await page.locator('body').innerText();
            expect(pageText).not.toContain('404 | Not Found');
            expect(pageText).not.toContain('500 | Server Error');
            expect(pageText).not.toContain('Illuminate\\Database\\QueryException'); 
            
            // Tunggu sesaat agar UI sempat di-render sepenuhnya
            await page.waitForLoadState('domcontentloaded');
        }

        console.log('✅ Semua menu berhasil dibuka tanpa error (404/500).');
    });
});
