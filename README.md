# 🏨 AI Hotel Image Description Generator

This project uses **Azure OpenAI** to generate clear, concise, and optionally promotional descriptions for hotel images. It helps hotel platforms automatically describe rooms, amenities, or areas for listings, accessibility tools, or customer insights.

## ✨ Features

* Upload or provide URLs for images of hotel rooms, bathrooms, dining areas, etc.
* Generates **1–2 sentence** descriptions using AI
* Option to include **promotional language** (e.g., "spacious", "elegant")
* Describes only what is **visibly present**: furniture, lighting, layout, colors
* Returns a warning if the image is **unsuitable for listings**

## 📊 Tech Stack

* **PHP** backend
* **Azure OpenAI API** for vision and language processing
* **HTML/CSS** frontend (extendable)
* Optional support for accessibility and localization

## 🚀 Getting Started

1. Clone the repository:

   ```bash
   git clone https://github.com/your-username/ai-hotel-image-description.git
   cd ai-hotel-image-description
   ```

2. Configure your Azure credentials in `config.php`:

   ```php
   define('AZURE_API_KEY', 'your-api-key');
   define('AZURE_ENDPOINT', 'your-endpoint-url');
   ```

3. Run the application:

   ```bash
   php -S localhost:8000 -t public
   ```

4. Open `http://localhost:8000` in your browser and test image URLs.

## 📃 Example Output

> *"The room is spacious with a large bed, warm-toned bedding, and soft ambient lighting. A wooden desk and window with curtains offer a cozy, elegant feel."*

> *If image content is not relevant:* *"Not suitable for listing."*

## 📅 Roadmap

*

## 📄 License

MIT License

---

Made with ❤️ for hotel businesses by \[Your Name]
