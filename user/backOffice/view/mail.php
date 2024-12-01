<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mail</title>
    <style>
        /* Global Styles */
        body {
            font-family: 'Arial', sans-serif;
            background: linear-gradient(135deg, #00796b, #004d40);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            flex-direction: column; /* Ensure elements stack vertically */
        }

        /* Footer Styles */
        .footer {
            margin-bottom: 20px; /* Space between footer and form */
            text-align: center;
            color: white;
            font-size: 14px;
        }

        /* Form Container */
        form {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        /* Form Labels */
        label {
            display: block;
            font-weight: bold;
            margin-bottom: 8px;
            color: #333;
        }

        /* Input Fields */
        input[type="email"],
        input[type="text"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
            font-size: 16px;
            background-color: #f9f9f9;
            transition: all 0.3s ease;
        }

        /* Focus Effect */
        input[type="email"]:focus,
        input[type="text"]:focus {
            border-color: #00796b;
            background-color: #e0f7fa;
            outline: none;
            box-shadow: 0 0 5px rgba(0, 121, 107, 0.5);
        }

        /* Submit Button */
        button {
            width: 100%;
            padding: 12px;
            background-color: #00796b;
            color: white;
            border: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: bold;
            cursor: pointer;
            transition: background-color 0.3s ease, transform 0.2s ease;
        }

        /* Button Hover Effect */
        button:hover {
            background-color: #004d40;
            transform: scale(1.05);
        }

        /* Responsive Design */
        @media (max-width: 480px) {
            form {
                padding: 20px;
                max-width: 100%;
            }
        }
    </style>
</head>
<body>
    
    <form action="send.php" method="post">
        <label for="email">Email</label>
        <input type="email" name="email" id="email" required>

        <label for="subject">Subject</label>
        <input type="text" name="subject" id="subject" required>

        <label for="message">Message</label>
        <input type="text" name="message" id="message" required>

        <button type="submit" name="send">Send</button>
    </form>
    <div class="footer">
        <p>&copy; 2024 All Rights Reserved by GreenHarvest.</p>
    </div>
</body>
</html>
