INSERT INTO `inspiration_category` (`id`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `slug`)
VALUES
	(1, 1, NULL, 1, 0, 2, 'inspiration');


INSERT INTO `inspiration_category_translation` (`id`, `translatable_id`, `title`, `locale`)
VALUES
	(1, 1, 'Inspiration', 'en'),
	(2, 1, 'Inspiration', 'th');


INSERT INTO `inspiration_category` (`id`, `tree_root`, `parent_id`, `lft`, `lvl`, `rgt`, `slug`, `is_top_page`, `image`)
VALUES
(2, 1, 1, 0, 1, 1, 'wellness-comfort', 1, '/uploads/userfiles/images/features/DUO_03.jpg'),
(3, 1, 1, 2, 1, 2, 'design-inspiration', 1, '/uploads/userfiles/images/news/gallery-post-02-original-1200x800.jpg');


INSERT INTO `inspiration_category_translation` (`id`, `translatable_id`, `title`, `locale`, `short_desc`)
VALUES
(3, 2, 'สุขภาพดี + ความสบาย', 'th', 'มีหลักฐานที่เป็นข้อเท็จจริงยืนยันมานานแล้ว ว่าเนื้อหาที่อ่านรู้เรื่องนั้นจะไปกวนสมาธิของคนอ่านให้เขวไปจากส่วนที้เป็น Layout เรานำ Lorem Ipsum มาใช้เพราะความที่มันมีการกระจายของตัวอักษรธรรมดาๆ แบบพอประมาณ ซึ่งเอามาใช้แทนการเขียนว่า ‘ตรงนี้เป็นเนื้อหา, ตรงนี้เป็นเนื้อหา\' ได้ และยังทำให้มองดูเหมือนกับภาษาอังกฤษที่อ่านได้ปกติ ปัจจุบันมีแพ็กเกจของซอฟท์แวร์การทำสื่อสิ่งพิมพ์ และซอฟท์แวร์การสร้างเว็บเพจ (Web Page Editor) หลายตัวที่ใช้ Lorem Ipsum'),
(4, 2, 'Wellness & Comfort', 'en', 'It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using \'Content here, content here\', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text'),
(5, 3, 'แรงบันดาลใจในการออกแบบ', 'th', 'มีท่อนต่างๆ ของ Lorem Ipsum ให้หยิบมาใช้งานได้มากมาย แต่ส่วนใหญ่แล้วจะถูกนำไปปรับให้เป็นรูปแบบอื่นๆ อาจจะด้วยการสอดแทรกมุกตลก หรือด้วยคำที่มั่วขึ้นมาซึ่งถึงอย่างไรก็ไม่มีทางเป็นเรื่องจริงได้เลยแม้แต่น้อย ถ้าคุณกำลังคิดจะใช้ Lorem Ipsum สักท่อนหนึ่ง คุณจำเป็นจะต้องตรวจให้แน่ใจว่าไม่มีอะไรน่าอับอายซ่อนอยู่ภายในท่อนนั้นๆ ตัวสร้าง Lorem Ipsum บนอินเทอร์เน็ตทุกตัวมักจะเอาท่อนที่แน่ใจแล้วมาใช้ซ้ำๆ ทำให้กลายเป็นที่มาของตัวสร้างที่แท้จริงบนอินเทอร์เน็ต'),
(6, 3, 'Design Inspiration', 'en', 'There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don\'t look even slightly believable. If you are going to use a passage of Lorem Ipsum, you need to be sure there isn\'t anything embarrassing hidden in the middle of text.');
