module.exports = (sequelize, DataTypes) => {
  const IngredientsUsed = sequelize.define('IngredientsUsed', {
    ingreID: {
      type: DataTypes.INTEGER,
      unique: 'compositeIndex'
    },
	menuID: {
      type: DataTypes.INTEGER,
      unique: 'compositeIndex'
    },
    quantity: {
      type: DataTypes.INTEGER
    }
  })