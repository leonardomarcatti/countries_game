<></>
<h1>🌍 Capital Quiz Game</h1>

<p>A web quiz game where players must guess the capital of different countries. Built with Laravel 12 and fully containerized using Docker.</p>

<h2>📖 About the Project</h2>
<p>Capital Quiz Game is a web-based quiz application where players test their geography knowledge by guessing the capital cities of various countries.</p>
<p>The game presents random countries, validates answers, and calculates the final score.</p>
<p>This project was developed using:</p>
<ul>
    <li>✅ Laravel 12</li>
    <li>✅ Docker (containerized environment)</li>
    <li>✅ MVC architecture</li>
    <li>✅ Clean code practices</li>
</ul>

<h2>🚀 Features</h2>
<ul>
    <li>🎯 Random country questions</li>
    <li>🧠 Capital validation logic</li>
    <li>📊 Score tracking system</li>
    <li>🔄 Replay option</li>
    <li>💾 Session-based state management</li>
    <li>🐳 Fully Dockerized environment</li>
</ul>

<h2>🛠️ Tech Stack</h2>
<ul>
    <li>Laravel 12</li>
    <li>PHP 8+</li>
    <li>Docker</li>
    <li>Docker Compose</li>
    <li>MySQL</li>
    <li>Blade Templates</li>
    <li>Eloquent ORM</li>
</ul>

<h2>🐳 Docker Setup</h2>
<p>This project runs entirely inside Docker containers.</p>
<h3>📦 Containers</h3>
<p>App (Laravel + PHP)</p>
<p>Database - MySQL</p>

⚙️ Running with Docker
<></>
Clone the repository:
<></>
git clone https://github.com/your-username/capital-quiz.git
cd capital-quiz
<></>

Build and start the containers:
<></>
docker compose up --build
<></>

Run migrations:
<></>
docker compose exec app php artisan migrate
<></>

Access the application:
<></>
http://localhost:8000

<></>
To stop containers:
<></>
docker compose down

🧱 Project Structure
.
├── app/
├── bootstrap/
├── config/
├── database/
├── public/
├── resources/
├── routes/
├── storage/
├── tests/
├── compose.yml
├── Dockerfile
├── entrypoint.sh
└── README.md


🎮 How to Play

Start the game

A country is displayed

Enter or select the correct capital

Submit your answer

View your final score

📸 Screenshots


📈 Future Improvements

⏱️ Timer mode

🌎 Difficulty levels

🏆 Global ranking system

👤 User authentication

📊 Player statistics dashboard

👨‍💻 Author

Leonardo Marcatti da Silva
Full-Stack Developer focused on Laravel & React
Passionate about technology 🚀
