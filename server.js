require('dotenv').config(); // تحميل المتغيرات البيئية من .env

const express = require('express');
const app = express();
const PORT = process.env.PORT || 3000;

// إرسال الـ token إلى الواجهة الأمامية عبر API
app.get('/api/token', (req, res) => {
  const githubToken = process.env.GITHUB_TOKEN;
  res.json({ githubToken });
});

app.listen(PORT, () => {
  console.log(`Server running on port ${PORT}`);
});
