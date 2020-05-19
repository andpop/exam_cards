$(document).ready(() => {

    const cardTemplate = $('#card-template');
    let cardTemplateHTML = cardTemplate.html();

    $('body').on('click', '.btn', handleButtonClicks);

    function handleButtonClicks(e) {
        function inputStudent() {
            cardInputStudent.css('visibility', 'visible');
            btnChoose.css('display', 'none');
            btnTake.css('display', 'inline-block');
            btnCancel.css('display', 'inline-block');
        }

        function cancelInput() {
            cardInputStudent.css('visibility', 'hidden');
            btnChoose.css('display', 'inline-block');
            btnTake.css('display', 'none');
            btnCancel.css('display', 'none');
        }

        function takeCard() {
            const number = card.attr('data-number');
            const student = cardInputStudent.val();

            sendLockedCard(number, student);
        }

        const button = $(e.target);
        const card = button.closest('.card');
        const cardInputStudent = card.find('.card__input-student');
        const btnChoose = card.find('.btn__choose');
        const btnTake = card.find('.btn__take');
        const btnCancel = card.find('.btn__cancel');

        if (button.hasClass('btn__choose')) {
            inputStudent();
        } else if (button.hasClass('btn__cancel')) {
            cancelInput();
        } else if (button.hasClass('btn__take')) {
            takeCard();
        }

    }

    function buildCardsListContent(cards) {

        function buildCardsItem(card) {
            // console.log(card);
    
            const cardItem = $(`<li>${cardTemplateHTML}</li>`);
            const cardContainer = cardItem.find('.card');
            const cardTitle = cardItem.find('.card__title');
            const cardInputStudent = cardItem.find('.card__input-student');
            const cardStudent = cardItem.find('.card__student');
            const cardLink = cardItem.find('.card__link');
            const btnChoose = cardItem.find('.btn__choose');
            const btnTake = cardItem.find('.btn__take');
            const btnCancel = cardItem.find('.btn__cancel');
    
            cardTitle.text(`Билет ${card['number']}`);
            cardContainer.attr('data-number', card['number']);
            cardStudent.text(card['student']);
    
            if (card['isLocked']) {
                cardContainer.css('background-color', 'yellow');
                cardInputStudent.css('visibility', 'hidden');    
                cardStudent.css('visibility', 'visible');
                cardLink.attr('href', card['filePath']);
                cardLink.css('visibility', 'visible');
                btnChoose.css('display', 'none');
                btnTake.css('display', 'none');
                btnCancel.css('display', 'none');
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

        // $.ajax({
        //     url: 'cards-api.php',
        //     success: (cards) => {
        //         const cardsList = $('.cards__list');
        //         const cardsItems = $(buildCardsListContent(cards));

        //         cardsList.empty();
        //         cardsList.append(cardsItems);
        //     }
        // });
    }

    function sendLockedCard(number, student) {
        console.log(`Студет ${student} взял билет ${number}`);
        queryCardsList();
        
    }

    queryCardsList();

});