module.exports = {
  port: process.env.PORT || 3000,

  db: {
    name: process.env.DB_NAME || 'lecafe',
    user: process.env.DB_USER || 'root',
    password: process.env.DB_PASS || '',

    options: {
      dialect: process.env.DIALECT || 'mysql',
      host: process.env.HOST || 'localhost',
      port: process.env.PORT || 3306,

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
  }
}
