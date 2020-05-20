$(document).ready(() => {

    const cardTemplate = $('#card-template');
    let cardTemplateHTML = cardTemplate.html();

    let interval;
    let isEditCardMode = false;

    if (typeof interval !== "undefined") {
        clearInterval(interval);
    }

    interval = setInterval(() => {
        if (isEditCardMode) return;
        queryCardsList();
    }, 3000);
     

    $('body').on('click', '.btn', handleButtonClicks);

    function handleButtonClicks(e) {
        const button = $(e.target);
        const card = button.closest('.card');
        const cardInputStudent = card.find('.card__input-student');

        if (button.hasClass('btn__choose')) {
            if (!isEditCardMode) {
                isEditCardMode = true;
                card.addClass('card_input-student');
            }

        } else if (button.hasClass('btn__cancel')) {
            isEditCardMode = false;
            card.removeClass('card_input-student');

        } else if (button.hasClass('btn__take')) {
            isEditCardMode = false;
            const cardInfo = {
                number: card.attr('data-number'),
                file: card.attr('data-file'),
                student: cardInputStudent.val()
            };
            sendLockedCard(cardInfo);
        }
    }

    function buildCardsListContent(cards) {

        function buildCardsItem(card) {
            const cardItem = $(`<li>${cardTemplateHTML}</li>`);
            const cardContainer = cardItem.find('.card');
            const cardTitle = cardItem.find('.card__title');
            const cardStudent = cardItem.find('.card__student');
            const cardLink = cardItem.find('.card__link');
    
            cardTitle.text(`Билет ${card['number']}`);
            cardContainer.attr('data-number', card['number']);
            cardContainer.attr('data-file', card['fileName']);
            cardStudent.text(card['student']);
    
            if (card['isLocked']) {
                cardContainer.addClass('card_locked');
                cardLink.attr('href', card['downloadPath']);
            }
            return '<li>' + cardItem.html() + '</li>';
        }
    
        let cardsList = '';

        for (const key in cards) {
            const card = cards[key];
            cardsList += buildCardsItem(card);
        }

        return cardsList;
    }

    async function queryCardsList() {
        // console.log('refresh page');
        
        let response = await fetch('cards-api.php');
        if (response.ok) {
            let cards = await response.json();
            const cardsList = $('.cards__list');
            const cardsItems = $(buildCardsListContent(cards));

            cardsList.empty();
            cardsList.append(cardsItems);
        } else {
            alert("Ошибка HTTP: " + response.status);
        }
    }

    function sendLockedCard(cardInfo) {
        $.ajax({
            type: "POST",
            url: "cards-api.php",
            data: cardInfo,
            dataType: "json",
            success: (response) => {
                queryCardsList();
            },
            error: (jqXHR, exception) => {
                alert(`Ошибка на сервере\n код: ${jqXHR.status} ${exception}`);
                queryCardsList();
            }
        });

    }

    queryCardsList();
});