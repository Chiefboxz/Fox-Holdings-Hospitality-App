module.exports = (sequelize, DataTypes) => {
  const Ingredients = sequelize.define('Ingredients', {
    ingreID: {
      type: DataTypes.INTEGER,
      primaryKey: true
    },
    ingreName: {
      type: DataTypes.STRING
    },
    ingreDescription: {
      type: DataTypes.TEXT
    }
  })

  return Ingredients
}
