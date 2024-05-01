<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Impact of Binge Eating and Drinking on the Liver</title>
    <style>
         body {
    font-family: 'Arial', sans-serif;
    background-color: #f9f9f9;
    margin: 0;
    padding: 0;
}

.article-content {
    background: #fff;
    margin: 2rem auto;
    padding: 2rem;
    max-width: 800px;
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.08);
    border-radius: 10px;
    border-left: 5px solid #2c3e50;
    transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
}

.article-content:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(0, 0, 0, 0.12);
}

h1, h3 {
    text-align: center;
    color: #2c3e50;
}

h1 {
    font-size: 2.5rem;
    margin-bottom: 0.5rem;
}

h3 {
    font-size: 1.5rem;
    font-weight: normal;
    color: #18a689;
    margin-top: 0;
}

.article-meta {
    text-align: center;
    color: #6c757d;
    font-style: italic;
}

.category {
    display: inline-block;
    background-color: #18a689;
    color: #fff;
    padding: 0.3rem 1rem;
    border-radius: 20px;
    font-size: 0.9rem;
}

hr {
    border: 0;
    height: 1px;
    background-image: linear-gradient(to right, rgba(0, 0, 0, 0), #18a689, rgba(0, 0, 0, 0));
    margin: 2rem 0;
}

h4 {
    color: #2c3e50;
    margin-top: 2rem;
}

p {
    text-align: justify;
    line-height: 1.6;
    color: #333;
}

a {
    display: inline-block;
    background-color: #2c3e50;
    color: #fff;
    padding: 0.5rem 1rem;
    border-radius: 20px;
    text-decoration: none;
    transition: background-color 0.3s;
    margin-top: 1rem;
}

a:hover {
    background-color: #18a689;
}

.back-to-home {
    background-color: transparent;
    color: #18a689;
    border: 2px solid #18a689;
    margin-top: 2rem;
}

.back-to-home:hover {
    background-color: #18a689;
    color: #fff;
}

.footer-text {
    text-align: center;
    font-size: 0.9rem;
    color: #6c757d;
    margin-top: 2rem;
}

.join-conversation {
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0% {
        box-shadow: 0 0 0 0 rgba(24, 166, 137, 0.7);
    }
    70% {
        box-shadow: 0 0 0 10px rgba(24, 166, 137, 0);
    }
    100% {
        box-shadow: 0 0 0 0 rgba(24, 166, 137, 0);
    }
}
.feedback-section {
    background: #f9f9f9;
    padding: 1rem;
    margin-top: 2rem;
    border-radius: 5px;
}

.feedback-section h2 {
    color: #2c3e50;
}

.feedback-section form {
    display: flex;
    flex-direction: column;
}

.feedback-section label {
    margin-top: 1rem;
}

.feedback-section input,
.feedback-section textarea {
    font: inherit;
    padding: 0.5rem;
    margin-top: 0.5rem;
    border: 1px solid #ccc;
    border-radius: 3px;
}

.feedback-section .submit-btn {
    padding: 0.5rem 1rem;
    background-color: #2c3e50;
    color: white;
    border: none;
    border-radius: 3px;
    cursor: pointer;
    margin-top: 1rem;
}

.feedback-section .submit-btn:hover {
    background-color: #18a689;
}

    </style>
</head>
<body>

<div class="article-content">
    <h1>How do Binge Eating and Drinking Impact the Liver?</h1>
    <h3>Exploring the Consequences on Liver Health</h3>
    <p class="article-meta">By Admin - Specialist | April 28, 2024<br>
    <span class="category">Health and Nutrition</span></p>
    <hr>

    <h4>Introduction</h4>
    <p>Excessive consumption of food and alcohol has immediate and long-term effects on liver function. This article examines the science behind how binge behaviors can lead to serious liver conditions.</p>

    <h4>The Liver's Response to Excess</h4>
    <p>The liver is a vital organ for processing nutrients and toxins. We'll look at how overindulgence can overwhelm this system, leading to fatty liver disease and other health issues.</p>

    <h4>Preventing Liver Damage</h4>
    <p>Understanding the risks is the first step in prevention. Learn strategies to protect your liver from the impacts of binge eating and drinking.</p>

    <h4>Conclusion</h4>
    <p>Responsible habits are key to maintaining liver health. Moderation, balanced nutrition, and regular check-ups are crucial, especially if previous episodes of binge behavior have occurred.</p>
    <hr>

    <p class="footer-text">Have you or someone you know been affected by liver issues due to dietary habits? Share your experiences and join the discussion on healthy living.</p>
    <hr>

<div class="feedback-section">
    <h2>We'd love your feedback</h2>
    <p>What are your thoughts on the impact of binge eating and drinking on liver health? Have you found effective strategies for managing these habits? Share your experiences and insights with us.</p>
    <form action="YOUR_SERVER_ENDPOINT" id="feedbackForm" method="post">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required>

        <label for="feedback">Your Feedback:</label>
        <textarea id="feedback" name="feedback" rows="4" required></textarea>

        <button type="submit" class="submit-btn">Submit Feedback</button>
    </form>
</div>
    <a href="#" class="join-conversation">Join the Discussion</a><br>
    <a href="index.html" class="back-to-home">Back to Home</a>
</div>
<script>
    document.getElementById('feedbackForm').addEventListener('submit', function(event) {
        event.preventDefault(); 
    
        alert('Thank you for your feedback!');
        this.reset();
    });
</script>

</body>
</html>
