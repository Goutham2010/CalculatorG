
const express = require('express');
const fileUpload = require('express-fileupload');
const { exec } = require('child_process');
const app = express();
const port = process.env.PORT || 3000;

app.use(express.json());
app.use(fileUpload());

app.post('/convert', (req, res) => {
  if (!req.files || !req.files.webm) {
    return res.status(400).json({ error: 'No WebM file uploaded.' });
  }

  const webmFile = req.files.webm;
  const outputMP4 = 'output.mp4';

  webmFile.mv('input.webm', (err) => {
    if (err) {
      return res.status(500).send(err);
    }

    const ffmpegCommand = `ffmpeg -i input.webm -c:v libx264 -crf 23 -c:a aac -strict experimental ${outputMP4}`;

    exec(ffmpegCommand, (error, stdout, stderr) => {
      if (error) {
        console.error(`Error: ${error}`);
        res.status(500).json({ error: 'Conversion failed' });
      } else {
        console.log(`Conversion successful: ${outputMP4}`);
        res.status(200).json({ message: 'Conversion successful', outputMP4 });
      }
    });
  });
});

app.listen(port, () => {
  console.log(`Server is running on port ${port}`);
});

