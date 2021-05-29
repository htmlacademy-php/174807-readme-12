<section class="page__main page__main--popular">
    <div class="container">
        <h1 class="page__title page__title--popular">Популярное</h1>
    </div>
    <div class="popular container">
        <div class="popular__filters-wrapper">
            <div class="popular__sorting sorting">
                <b class="popular__sorting-caption sorting__caption">Сортировка:</b>
                <ul class="popular__sorting-list sorting__list">
                    <li class="sorting__item sorting__item--popular">
                        <a class="sorting__link sorting__link--active" href="#">
                            <span>Популярность</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Лайки</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                    <li class="sorting__item">
                        <a class="sorting__link" href="#">
                            <span>Дата</span>
                            <svg class="sorting__icon" width="10" height="12">
                                <use xlink:href="#icon-sort"></use>
                            </svg>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="popular__filters filters">
                <b class="popular__filters-caption filters__caption">Тип контента:</b>
                <ul class="popular__filters-list filters__list">
                    <li class="popular__filters-item popular__filters-item--all filters__item filters__item--all">
                        <a class="filters__button filters__button--ellipse filters__button--all <?= $activeFilter === 'all' ? 'filters__button--active' : '' ?>"
                           href="/?filter=all">
                            <span>Все</span>
                        </a>
                    </li>
                    <?php foreach ($categories as $category):
                        $icon = $category['icon'];
                        $type = $category['type'];
                        $activeCategory = $activeFilter === $icon;
                    ?>
                        <li class="popular__filters-item filters__item">
                            <a class="filters__button filters__button--<?= $icon ?> button <?= $activeCategory ? 'filters__button--active' : '' ?>" href="/?filter=<?= $icon ;?>">
                                <span class="visually-hidden"><?= $type ;?></span>
                                <svg class="filters__icon" width="22" height="18">
                                    <use xlink:href="#icon-filter-<?= $icon;?>"></use>
                                </svg>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
        <div class="popular__posts">
            <?php foreach ($posts as $index => $post):
                $postTitle = htmlspecialchars($post['title']);
                $postContent = htmlspecialchars($post['content']);
                $postDate = generate_random_date($index);
                $dateTitle = date('d.m.Y H:i', strtotime($postDate));
                $dateDifferenceText = getDateDifferenceText($postDate); ?>

                <article class="popular__post post post-<?= $post['icon']; ?>">
                    <header class="post__header">
                        <h2><a href="#"><?= $postTitle; ?></a></h2>
                    </header>
                    <div class="post__main">
                        <?php if ($post['type'] === 'Цитата'): ?>
                            <blockquote>
                                <p>
                                    <?= $postContent; ?>
                                </p>
                                <cite>Неизвестный Автор</cite>
                            </blockquote>
                        <?php elseif ($post['type'] === 'Текст'): ?>
                            <?php if (mb_strlen($post['content']) <= $maxTextLength): ?>
                                <p><?= $postContent; ?></p>
                            <?php else: ?>
                                <p><?= htmlspecialchars(trimText($post['content'], $maxTextLength)) . '...'; ?></p>
                                <a class="post-text__more-link" href="#">Читать далее</a>
                            <?php endif; ?>
                        <?php elseif ($post['type'] === 'Ссылка'): ?>
                            <div class="post-link__wrapper">
                                <a class="post-link__external" href="http://" title="Перейти по ссылке">
                                    <div class="post-link__info-wrapper">
                                        <div class="post-link__icon-wrapper">
                                            <img src="https://www.google.com/s2/favicons?domain=vitadental.ru" alt="Иконка">
                                        </div>
                                        <div class="post-link__info">
                                            <h3><?= $postTitle; ?></h3>
                                        </div>
                                    </div>
                                    <span><?= $postContent; ?></span>
                                </a>
                            </div>

                        <?php elseif ($post['type'] === 'Картинка'): ?>
                            <div class="post-photo__image-wrapper">
                                <img src="img/<?= $postContent; ?>" alt="Фото от пользователя" width="360" height="240">
                            </div>

                        <?php elseif ($post['type'] === 'Видео'): ?>
                            <div class="post-video__block">
                                <div class="post-video__preview">
                                    <?= embed_youtube_cover($postContent); ?>
                                    <img src="img/coast-medium.jpg"  alt="Превью к видео" width="360" height="188">
                                </div>
                                <a href="post-details.html" class="post-video__play-big button">
                                    <svg class="post-video__play-big-icon" width="14" height="14">
                                        <use xlink:href="#icon-video-play-big"></use>
                                    </svg>
                                    <span class="visually-hidden">Запустить проигрыватель</span>
                                </a>
                            </div>
                        <?php endif; ?>
                    </div>
                    <footer class="post__footer">
                        <div class="post__author">
                            <a class="post__author-link" href="#" title="Автор">
                                <div class="post__avatar-wrapper">
                                    <img class="post__author-avatar" src="img/<?= $post['avatar_url']; ?>" alt="Аватар пользователя <?= $post['username']; ?>">
                                </div>
                                <div class="post__info">
                                    <b class="post__author-name"><?= $post['username']; ?></b>
                                    <time class="post__time"
                                          datetime="<?= $postDate; ?>"
                                          title="<?= $dateTitle; ?>">
                                        <?= $dateDifferenceText ?>
                                    </time>
                                </div>
                            </a>
                        </div>
                        <div class="post__indicators">
                            <div class="post__buttons">
                                <a class="post__indicator post__indicator--likes button" href="#" title="Лайк">
                                    <svg class="post__indicator-icon" width="20" height="17">
                                        <use xlink:href="#icon-heart"></use>
                                    </svg>
                                    <svg class="post__indicator-icon post__indicator-icon--like-active" width="20"
                                         height="17">
                                        <use xlink:href="#icon-heart-active"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество лайков</span>
                                </a>
                                <a class="post__indicator post__indicator--comments button" href="#"
                                   title="Комментарии">
                                    <svg class="post__indicator-icon" width="19" height="17">
                                        <use xlink:href="#icon-comment"></use>
                                    </svg>
                                    <span>0</span>
                                    <span class="visually-hidden">количество комментариев</span>
                                </a>
                            </div>
                        </div>
                    </footer>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>
