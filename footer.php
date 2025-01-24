<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location Map - CateringApp</title>
    <style>
        /* Footer Styling */
        footer {
            background-color: #333;
            color: white;
            padding: 20px 20px;
            text-align: center;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            padding: 20px;
        }

        .footer-section {
            flex: 1;
            min-width: 250px;
            margin: 10px;
        }

        .footer-section h3 {
            color: #ff6600;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .footer-section p {
            font-size: 14px;
            color: #ccc;
        }

        .footer-section a {
            color: #ff6600;
            text-decoration: none;
        }

        .footer-section a:hover {
            text-decoration: underline;
        }

        /* Map Styling */
        #location-map {
            width: 100%;
            height: 250px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        /* Footer Bottom */
        .footer-bottom {
            background-color: #222;
            color: #fff;
            padding: 20px;
            text-align: center;
            margin-top: 20px;
        }

        .footer-bottom p {
            font-size: 14px;
        }

        /* Responsif untuk mobile */
        @media (max-width: 768px) {
            .footer-content {
                flex-direction: column;
                align-items: center;
            }

            .footer-section {
                text-align: center;
                margin-bottom: 20px;
            }

            #location-map {
                height: 200px; /* Adjust map height on mobile */
            }
        }
    </style>
</head>
<body>

    <footer>
        <div class="footer-content">
            <div class="footer-section contact">
                <h3>Contact Us</h3>
                <p>Phone: (021) 123456789</p>
                <p>Email: support@CateringFood.com</p>
                <p>Address: Jl. Solo - Karanganyar</p>
            </div>

            <div class="footer-section location">
                <h3>Location</h3>
                <!-- Embed Google Maps with Iframe -->
                <div id="location-map">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1988.928896874658!2d106.678760!3d-6.229296!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69e1d1b1a4e3f5%3A0x5f6236dfc80f313b!2sJl.%20Solo%20-%20Karanganyar!5e0!3m2!1sid!2sid!4v1682030839992!5m2!1sid!2sid" 
                        width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                </div>
            </div>

            <div class="footer-section social-media">
                <h3>Follow Us</h3>
                <a href="https://facebook.com" target="_blank">Facebook</a> | 
                <a href="https://twitter.com" target="_blank">Twitter</a> | 
                <a href="https://instagram.com" target="_blank">Instagram</a>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2024 CateringFood. All Rights Reserved.</p>
        </div>
    </footer>

</body>
</html>
