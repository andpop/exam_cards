$(document).ready(() => {

    const cardTemplate = $('#card-template');
    let cardTemplateHTML = cardTemplate.html();

    $('body').on('click', '.btn', handleButtonClicks);

    function handleButtonClicks(e) {
        const button = $(e.target);
        const card = button.closest('.card');
        const cardInputStudent = card.find('.card__input-student');
        const number = card.attr('data-number');

        if (button.hasClass('btn__choose')) {
            card.addClass('card_input-student');
        } else if (button.hasClass('btn__cancel')) {
            card.removeClass('card_input-student');
        } else if (button.hasClass('btn__take')) {
            sendLockedCard(number, cardInputStudent.val());
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
            cardStudent.text(card['student']);
    
            if (card['isLocked']) {
                cardContainer.addClass('card_locked');
                cardLink.attr('href', card['filePath']);
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

    async function sendLockedCard(number, student) {
        const cardInfo = {
            number: number, 
            student: student
        };

        $.ajax({
            type: "POST",
            url: "cards-api.php",
            data: cardInfo,
            dataType: "json",
            success: (response) => {
                queryCardsList();
            }
        });

    }

    queryCardsList();

});