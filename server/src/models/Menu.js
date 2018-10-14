module.exports = (sequelize, DataTypes) => {
  const Menu = sequelize.define('Menu', {
    menuID: {
      type: DataTypes.INTEGER,
      primaryKey: true
    },
    menuItem: {
      type: DataTypes.STRING
    },
    menuPrice: {
      type: DataTypes.DOUBLE
    },
    menuCatagory: {
      type: DataTypes.STRING
    },
    menuDescription: {
      type: DataTypes.TEXT
    }
  })
}
