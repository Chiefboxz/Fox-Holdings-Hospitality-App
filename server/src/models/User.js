module.exports = (sequelize, DataTypes) =>
  sequelize.define('Customer', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true
    }
  })
