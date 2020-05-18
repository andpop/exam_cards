$(document).ready(() => {
    
    $.ajax({
        url: 'cards-api.php',
        success: (cards) => {
            console.log(cards);
            console.log(data.children.length);
            for (const key in cards) {
                const card = cards[key];
                console.log(card);
            }
        }
      });
});