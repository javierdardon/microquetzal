export function getInterest( price ) {
    const calculateInterest = ( interest ) => {
      const interestAmount = price * interest;
      const totalPrice = price + interestAmount;
      return totalPrice.toFixed(2);
    };

    const interests = [
      {
        quantity: 3,
        total: calculateInterest(0.01),
        monthly: ((calculateInterest(0.01) / 3)).toFixed(2)
      },
      {
        quantity: 6,
        total: calculateInterest(0.02),
        monthly: ((calculateInterest(0.02) / 6)).toFixed(2)
      },
      {
        quantity: 10,
        total: calculateInterest(0.03),
        monthly: ((calculateInterest(0.03) / 10)).toFixed(2)
      },
      {
        quantity: 12,
        total: calculateInterest(0.09),
        monthly: ((calculateInterest(0.09) / 12)).toFixed(2)
      },
      {
        quantity: 15,
        total: calculateInterest(0.05),
        monthly: ((calculateInterest(0.05) / 15)).toFixed(2)
      },
      {
        quantity: 18,
        total: calculateInterest(0.07),
        monthly: ((calculateInterest(0.07) / 18)).toFixed(2)
      },
    ]

    return interests
  }
