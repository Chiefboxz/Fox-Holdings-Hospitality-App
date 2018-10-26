module.exports = (sequelize, DataTypes) => {
  const Order = sequelize.define('Order', {
    
    orderID: {
      type: DataTypes.INTEGER,
      autoIncrement: true
  },
    complete: {
      type: DataTypes.int,
      default:0
    },
    orderQuantity: {
      type: DataTypes.INTEGER
    },
    orderTime: {
      type: DataTypes.DATE
    },
    orderCollection: {
      type: DataTypes.DATE
    }
  })

  return Order
}
