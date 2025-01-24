<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQ & Tentang Kami - Pemesanan Catering</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Font Awesome (untuk ikon jika diperlukan) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet"/>
    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="style.css"> <!-- Link to the external CSS file -->
</head>
<body class="bg-gray-100 text-gray-800">

<!-- Navigasi -->
<?php include('navbar.php'); ?>

<!-- Header -->
<header class="bg-black text-white text-center py-12">
    <h1 class="text-5xl font-bold">Tentang Kami & FAQ</h1>
    <p class="mt-4 text-lg">Mengenal lebih dekat dengan layanan kami dan pertanyaan umum</p>
</header>

<!-- Main Content -->
<main class="px-4 py-8 md:px-16 lg:px-32">
    <!-- Informasi Perusahaan -->
    <section class="mb-8">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Informasi Perusahaan</h2>
        <p class="text-lg leading-relaxed text-gray-700">
            CATERINGFOOD adalah pilihan utama Anda untuk pengalaman kuliner yang tak terlupakan. Sebagai pemimpin dalam industri katering, kami menawarkan layanan catering yang mencakup segala kebutuhan, mulai dari acara pribadi hingga perusahaan. Dengan menu yang dirancang khusus untuk memenuhi beragam selera dan preferensi, kami berkomitmen untuk memberikan hidangan berkualitas tinggi yang dipersembahkan dengan penuh cinta dan perhatian.
        </p>
    </section>

    <!-- Gambar -->
    <section class="mb-8">
        <img alt="A variety of delicious catering dishes beautifully arranged in bowls and plates" 
        class="w-full h-auto rounded-lg shadow-lg" src="images/abt.jpg" />
    </section>

    <!-- Visi & Misi -->
    <section class="mb-8">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Visi dan Misi</h2>
        <p class="text-lg leading-relaxed text-gray-700 mb-4">
            Visi kami adalah untuk menjadi penyedia layanan katering terkemuka di Indonesia, yang dikenal akan kualitas, keandalan, dan kreativitas dalam setiap hidangan yang kami sajikan. Kami bertujuan untuk terus berinovasi dan memberikan pelayanan yang terbaik untuk memenuhi kebutuhan setiap pelanggan.
        </p>
        <p class="text-lg leading-relaxed text-gray-700">
            Misi kami adalah menyediakan layanan katering yang tidak hanya memenuhi ekspektasi, tetapi juga memberikan pengalaman kuliner yang tak terlupakan. Kami berkomitmen untuk selalu menjaga standar kualitas tertinggi dan memberikan pelayanan yang ramah serta profesional.
        </p>
    </section>

    <!-- Tim Kami -->
    <section class="mb-8">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Tim Kami</h2>
        <div class="flex flex-wrap gap-8 justify-center">
            <div class="text-center">
                <img alt="Chef image" class="w-32 h-32 rounded-full mx-auto mb-4" src="images/abt_jisoo.avif" />
                <h3 class="font-semibold text-xl">Owner Moana</h3>
                <p class="text-gray-700">Owner Catering</p>
            </div>
            <div class="text-center">
                <img alt="Manager image" class="w-32 h-32 rounded-full mx-auto mb-4" src="images/abt_irene1.jpg" />
                <h3 class="font-semibold text-xl">Manager Vannesa</h3>
                <p class="text-gray-700">Manajer Operasional</p>
            </div>
        </div>
    </section>

   <!-- FAQ Section -->
<section class="faq-section">
    <div class="faq-container">
        <h2 class="text-3xl font-bold mb-4 text-gray-900">Frequently Asked Questions (FAQ)</h2>

        <!-- FAQ 1 -->
        <div class="faq-item">
            <h3>1. Bagaimana cara memesan catering?</h3>
            <p>Anda dapat memesan catering melalui website kami dengan memilih menu yang Anda inginkan. Setelah memilih, klik tombol "Pesan Sekarang" dan ikuti langkah-langkah untuk mengisi data pemesanan.</p>
        </div>

        <!-- FAQ 2 -->
        <div class="faq-item">
            <h3>2. Apakah saya bisa mengubah pesanan setelah dikirim?</h3>
            <p>Jika pesanan Anda belum diproses, Anda dapat menghubungi kami melalui kontak yang tertera di website untuk melakukan perubahan. Namun, setelah pesanan diproses, perubahan tidak dapat dilakukan.</p>
        </div>

        <!-- FAQ 3 -->
        <div class="faq-item">
            <h3>3. Apakah saya bisa membatalkan pesanan yang sudah saya buat?</h3>
            <p>Anda bisa membatalkan pesanan, tetapi hanya dalam waktu 24 jam setelah pemesanan dilakukan. Silakan hubungi kami segera untuk proses pembatalan.</p>
        </div>

        <!-- FAQ 4 -->
        <div class="faq-item">
            <h3>4. Bagaimana cara melakukan pembayaran?</h3>
            <p>Setelah Anda mengkonfirmasi pesanan, kami akan mengirimkan detail pembayaran yang bisa dilakukan melalui transfer bank atau menggunakan metode pembayaran lain yang tersedia di website kami.</p>
        </div>

        <!-- FAQ 5 -->
        <div class="faq-item">
            <h3>5. Apakah harga sudah termasuk pajak?</h3>
            <p>Ya, harga yang tercantum pada menu sudah termasuk pajak dan biaya layanan.</p>
        </div>

        <!-- FAQ 6 -->
        <div class="faq-item">
            <h3>6. Apakah ada diskon untuk pemesanan dalam jumlah besar?</h3>
            <p>Kami menyediakan diskon khusus untuk pemesanan dalam jumlah besar. Anda bisa menghubungi customer service untuk informasi lebih lanjut mengenai diskon yang tersedia.</p>
        </div>

        <!-- Saran dari Customer -->
        <div class="feedback-form">
            <h3>Berikan Saran Anda</h3>
            <form method="POST" action="submit_saran.php">
                <div class="mb-3">
                    <label for="customer_name" class="form-label">Nama Anda</label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label for="saran" class="form-label">Saran</label>
                    <textarea name="saran" id="saran" class="form-control" rows="10" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Kirim Saran</button>
            </form>
        </div>
    </div>
</section>
</main>

<!-- Footer -->
<?php include('footer.php'); ?>

</body>
</html>

