module.exports = (sequelize, DataTypes) => {
  const Order = sequelize.define('Order', {
    cID: {
      type: DataTypes.INTEGER,
      unique: 'compositeIndex'
    },
    menuID: {
      type: DataTypes.INTEGER,
      unique: 'compositeIndex'
    },
    orderDescription: {
      type: DataTypes.TEXT
    },
    orderQuantity: {
      type: DataTypes.INTEGER
    },
    orderTime: {
      type: DataTypes.DATE
    },
    orderCollection: {
      type: DataTypes.STRING
    }
  })

  return Order
}
