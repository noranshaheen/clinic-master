netstat -tulpn | grep :5173 | awk '{print $7}' | awk -F"/" '{print $1}' | xargs kill -9
npm run dev