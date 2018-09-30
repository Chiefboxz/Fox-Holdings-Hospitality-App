module.exports = (sequelize, DataTypes) => {
  sequelize.define('Menu', {
    id: {
      type: DataTypes.INTEGER,
      primaryKey: true
    },
    item: {
      type: DataTypes.STRING,
      unique: true
    },
    price: {
      type: DataTypes.STRING
    },
    category: {
      type: DataTypes.STRING,
    }
  })
}
