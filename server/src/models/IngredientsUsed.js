module.exports = (sequelize, DataTypes) => {
  const IngredientsUsed = sequelize.define('IngredientsUsed', {
    quantity: {
      type: DataTypes.INTEGER
    }
  })

  return IngredientsUsed
}
