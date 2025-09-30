module.exports = {
  apps: [
    {
      name: "node-ms",
      script: "./src/index.js",
      watch: false,
      instances: 1,
      env: {
        PORT: 3000,
        NODE_ENV: "development",
      },
      env_production: {
        PORT: 3000,
        NODE_ENV: "production",
      },
    },
  ],
};
