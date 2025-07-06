<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f9f9f9;
      color: #333;
      padding: 20px;
    }
    .email-container {
      background-color: #ffffff;
      padding: 20px;
      border-radius: 8px;
      max-width: 600px;
      margin: auto;
      box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    }
    .header {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 20px;
      color: #4a4a4a;
    }
    .section {
      margin-bottom: 15px;
    }
    .label {
      font-weight: bold;
      color: #555;
    }
    .footer {
      font-size: 12px;
      color: #888;
      margin-top: 30px;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="email-container">
    <div class="header">📅 Task Reminder</div>

    <div class="section">
      <span class="label">Task:</span> {{ $taskName }}
    </div>

    <div class="section">
      <span class="label">Deadline:</span> {{ $deadline }}
    </div>

    @if($description)
    <div class="section">
      <span class="label">Description:</span> {{ $description }}
    </div>
    @endif

    <div class="footer">
      This is an automated reminder from Priorify. Please do not reply to this email.
    </div>
  </div>
</body>
</html>
