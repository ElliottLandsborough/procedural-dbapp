#!/bin/bash  
git add .  
read -p "Commit description: " desc  
git commit -m "$desc"
git push https://github.com/ElliottLandsborough/procedural-dbapp.git
