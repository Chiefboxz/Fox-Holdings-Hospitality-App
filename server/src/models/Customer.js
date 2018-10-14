module.exports = (sequelize, DataTypes) => {
  const Customer = sequelize.define('Customer', {
    cID: {
      type: DataTypes.INTEGER,
      primaryKey: true
    },
    cFirstname: {
      type: DataTypes.STRING
    },
    cLastname: {
      type: DataTypes.STRING
    },
    cNumber: {
      type: DataTypes.INTEGER,
      unique: true
    },
    cEmail: {
      type: DataTypes.STRING
      unique: true
    },
    cPassword: {
      type: DataTypes.STRING,
    }
  })

  Customer.prototype.comparePassword = (cPassword) => {
    // We can compare passwords here with the model
    // Need to use jwt + passport + bcrypt
    return cPassword === this.cPassword
  }

  return Customer
}
