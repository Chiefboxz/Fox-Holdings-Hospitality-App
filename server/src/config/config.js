module.exports = {
  port: process.env.SERVER_PORT || 3000,

  db: {
    name: process.env.DB_NAME || 'lecafe',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASS || '',

    operatorsAliases: false,

    options: {
      dialect: process.env.DIALECT || 'mysql',
      host: process.env.DB_HOST || 'localhost',
      port: process.env.DB_PORT || 3306,

      define: {
        underscored: true,
        charset: 'utf8',
        dialectOptions: {
          collate: 'utf8_general_ci'
        },
        timestamps: true,
        paranoid: true
      },

      pool: {
        max: 50,
        idle: 30000,
        acuire: 60000
      }
    }
  },

  jwt: {
    secret: process.env.JWT_SECRET || 'LeCafe_Secret',
    expire: 604800 // One week tokken (One day: 86400)
  }
}
