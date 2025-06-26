const fs = require('fs').promises;
     module.exports = async (req, res) => {
         let visits = 0;
         try {
             visits = parseInt(await fs.readFile('visits.txt', 'utf8')) || 0;
         } catch (e) {}
         visits++;
         await fs.writeFile('visits.txt', visits.toString());
         res.json({ visits });
     };