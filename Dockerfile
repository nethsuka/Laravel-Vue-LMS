# Use Node.js LTS version
FROM node:20-alpine

# Set working directory
WORKDIR /app

# Copy package files
COPY package*.json ./

# Create exact versions package.json
RUN cat > package.json << 'EOL'
{
    "private": true,
    "type": "module",
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    },
    "devDependencies": {
        "@inertiajs/vue3": "1.0.0",
        "@tailwindcss/forms": "0.5.3",
        "@vitejs/plugin-vue": "5.0.0",
        "autoprefixer": "10.4.12",
        "axios": "1.6.4",
        "laravel-vite-plugin": "1.0.0",
        "postcss": "8.4.31",
        "tailwindcss": "3.2.1",
        "vite": "5.0.0",
        "vue": "3.4.0"
    },
    "dependencies": {
        "flowbite": "2.5.1",
        "flowbite-vue": "0.1.6",
        "js-sha256": "0.11.0",
        "primeicons": "7.0.0",
        "vue-draggable-plus": "0.6.0"
    }
}
EOL

# Install dependencies with exact versions
RUN npm install

# Copy the rest of the application
COPY . .

# Build the application
RUN npm run build

# Expose port if needed
EXPOSE 3000

# Start command
CMD ["npm", "run", "dev"]