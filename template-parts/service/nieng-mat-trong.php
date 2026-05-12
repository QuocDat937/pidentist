<?php
/**
 * Pi Dentist — Service Detail: Niềng mặt trong (Lingual Braces)
 *
 * Template part chuyên sâu cho /dich-vu/nieng-mat-trong/.
 * Render: TOC sidebar + rich content sections.
 *
 * @package Pidentist
 */

defined( 'ABSPATH' ) || exit;

$phone = esc_html( get_theme_mod( 'pi_phone', '0909 XXX XXX' ) );
?>

<div class="service-detail__layout">

	<!-- ─── Table of Contents (sticky sidebar) ──────────────── -->
	<aside class="service-toc reveal" aria-label="Mục lục bài viết">
		<p class="service-toc__title">Mục lục</p>
		<nav class="service-toc__list">
			<a href="#tong-quan" class="service-toc__link">Tổng quan</a>
			<a href="#cau-tao" class="service-toc__link">Cấu tạo & Nguyên lý</a>
			<a href="#uu-diem" class="service-toc__link">Ưu điểm nổi bật</a>
			<a href="#phu-hop" class="service-toc__link">Ai nên niềng?</a>
			<a href="#quy-trinh" class="service-toc__link">Quy trình điều trị</a>
			<a href="#so-sanh" class="service-toc__link">So sánh phương pháp</a>
			<a href="#cam-ket" class="service-toc__link">Cam kết tại Pi</a>
		</nav>
	</aside>

	<!-- ─── Main Content Column ─────────────────────────────── -->
	<div class="service-detail__content">

		<!-- ══ Section: Tổng quan ══════════════════════════════ -->
		<section class="service-content-section reveal" id="tong-quan">
			<h2 class="service-section-heading">Tổng quan về niềng mặt trong</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Niềng mặt trong (Lingual Braces) là phương pháp chỉnh nha sử dụng mắc cài gắn ở <strong>mặt trong (mặt lưỡi) của răng</strong>, hoàn toàn ẩn khi nhìn từ bên ngoài. Đây là giải pháp <strong>"niềng vô hình thực sự" bằng mắc cài cố định</strong> — phù hợp cho người yêu cầu thẩm mỹ tuyệt đối nhưng vẫn cần hiệu quả điều trị mạnh mẽ như mắc cài truyền thống.
				</p>
				<p>
					Tại Pi Dentist, hệ thống mắc cài mặt trong được <strong>chế tác riêng cho từng bệnh nhân (custom-made)</strong> bằng công nghệ CAD/CAM, kết hợp dây cung uốn bởi robot chính xác đến từng 0,01mm. Mỗi ca điều trị là một sản phẩm kỹ thuật hoàn toàn cá nhân hóa — không có hai bộ mắc cài nào giống nhau.
				</p>
			</div>

			<!-- Highlight box -->
			<div class="service-highlight-box">
				<p class="service-highlight-box__title">
					<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" width="22" height="22"><path d="M12 2L2 7l10 5 10-5-10-5z"/><path d="M2 17l10 5 10-5"/><path d="M2 12l10 5 10-5"/></svg>
					Bạn biết không?
				</p>
				<p>
					Niềng mặt trong là <strong>giải pháp duy nhất</strong> kết hợp được hiệu quả của mắc cài cố định và tính thẩm mỹ tuyệt đối 100% — không ai biết bạn đang niềng. Khác với niềng trong suốt (tháo lắp), mắc cài mặt trong hoạt động liên tục 24/7, xử lý được cả những ca phức tạp mà khay trong suốt không thể.
				</p>
			</div>
		</section>

		<!-- ══ Section: Cấu tạo & Nguyên lý ═══════════════════ -->
		<section class="service-content-section reveal" id="cau-tao">
			<h2 class="service-section-heading">Cấu tạo và nguyên lý hoạt động</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>
					Hệ thống niềng mặt trong gồm 4 thành phần chính, tất cả được chế tác riêng và lắp đặt bằng kỹ thuật gián tiếp (indirect bonding) để đảm bảo độ chính xác tuyệt đối:
				</p>
			</div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="8" width="18" height="8" rx="2"/><path d="M7 8V6a5 5 0 0 1 10 0v2"/></svg>
					</div>
					<div>
						<h4>Mắc cài lưỡi (Lingual Bracket)</h4>
						<p>Custom-made bằng hợp kim vàng hoặc thép không gỉ y tế, gắn ở mặt trong răng. Mỗi mắc cài được thiết kế riêng bằng CAD/CAM, ôm khít bề mặt răng từng bệnh nhân.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M2 12h20"/><path d="M6 8c2 0 3 4 6 4s4-4 6-4"/><circle cx="6" cy="12" r="1.5"/><circle cx="18" cy="12" r="1.5"/></svg>
					</div>
					<div>
						<h4>Dây cung tùy chỉnh (Custom Archwire)</h4>
						<p>Dây cung được uốn chính xác bởi robot theo dữ liệu 3D của từng bệnh nhân, tạo lực dịch chuyển tối ưu cho từng giai đoạn điều trị.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="3" width="18" height="18" rx="3"/><path d="M3 9h18"/><path d="M9 3v18"/></svg>
					</div>
					<div>
						<h4>Hệ thống gắn gián tiếp (Indirect Bonding)</h4>
						<p>Toàn bộ mắc cài được gắn cùng lúc bằng khay transfer chuyên dụng — đảm bảo vị trí chính xác tuyệt đối, giảm thời gian trên ghế nha khoa.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><path d="M12 8v4l3 3"/><path d="M8 3l1 2"/><path d="M16 3l-1 2"/></svg>
					</div>
					<div>
						<h4>Phụ kiện chuyên biệt</h4>
						<p>Bite plane (mặt phẳng cắn), micro-screw (vít mini cố định), thun liên hàm — hỗ trợ xử lý các ca phức tạp như cắn sâu, cắn hở, hô nặng.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ưu điểm nổi bật ═══════════════════════ -->
		<section class="service-content-section reveal" id="uu-diem">
			<h2 class="service-section-heading">Ưu điểm nổi bật</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/><line x1="1" y1="1" x2="23" y2="23"/></svg>
					</div>
					<div>
						<h4>Thẩm mỹ tuyệt đối — ẩn 100%</h4>
						<p>Mắc cài gắn hoàn toàn ở mặt trong răng — không ai nhìn thấy khi bạn nói chuyện, cười hay chụp ảnh. Vô hình thực sự.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
					</div>
					<div>
						<h4>Hiệu quả mạnh mẽ</h4>
						<p>Xử lý được hầu hết các ca phức tạp tương đương mắc cài ngoài — hô, móm, cắn sâu, chen chúc nặng, răng ngầm.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="6"/><circle cx="12" cy="12" r="2"/></svg>
					</div>
					<div>
						<h4>Custom-made chính xác</h4>
						<p>Mỗi bộ mắc cài và dây cung được chế tác riêng bằng CAD/CAM — ôm khít răng từng bệnh nhân, tối ưu lực dịch chuyển.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 0 1-3.46 0"/></svg>
					</div>
					<div>
						<h4>Phù hợp vận động viên & nhạc sĩ</h4>
						<p>Không có mắc cài ở mặt ngoài — không ảnh hưởng đến môi khi chơi nhạc cụ hơi, không gây chấn thương khi chơi thể thao đối kháng.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: Ai nên niềng? ═════════════════════════ -->
		<section class="service-content-section reveal" id="phu-hop">
			<h2 class="service-section-heading">Ai nên niềng mặt trong?</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Niềng mặt trong là lựa chọn cao cấp nhất trong các phương pháp mắc cài, đặc biệt phù hợp với:</p>
			</div>

			<div class="service-suited-list">
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người cần thẩm mỹ tuyệt đối: nghệ sĩ, MC, người mẫu, diễn viên
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người không muốn ai biết mình đang niềng răng
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Ca phức tạp mà niềng trong suốt (clear aligners) không xử lý được
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Vận động viên thể thao đối kháng (boxing, võ thuật, bóng đá)
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người chơi nhạc cụ hơi (kèn, sáo, trumpet)
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người trưởng thành muốn chỉnh nha kín đáo, chuyên nghiệp
				</div>
				<div class="service-suited-item">
					<span class="suited-icon" aria-hidden="true">✓</span>
					Người sẵn sàng đầu tư chi phí cao cho giải pháp tốt nhất
				</div>
			</div>
		</section>

		<!-- ══ Section: Quy trình điều trị ════════════════════ -->
		<section class="service-content-section reveal" id="quy-trinh">
			<h2 class="service-section-heading">Quy trình niềng mặt trong tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Mỗi ca niềng mặt trong tại Pi Dentist đều tuân theo quy trình <strong>5 bước chuẩn hóa</strong>, kết hợp công nghệ CAD/CAM và chuyên môn bác sĩ chỉnh nha chuyên sâu:</p>
			</div>

			<div class="service-process-steps">
				<div class="service-step">
					<div class="service-step__number">1</div>
					<div class="service-step__content">
						<p class="service-step__title">Tư vấn & Scan 3D kỹ thuật số</p>
						<p class="service-step__desc">Bác sĩ khám tổng quát, chụp X-quang panoramic + cephalometric, scan 3D iTero. Đánh giá chi tiết tình trạng răng, xương hàm và khớp cắn để xác định phác đồ điều trị tối ưu.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">2</div>
					<div class="service-step__content">
						<p class="service-step__title">Thiết kế mắc cài cá nhân hóa</p>
						<p class="service-step__desc">Dữ liệu 3D được gửi đến lab chuyên dụng để chế tác custom bracket bằng CAD/CAM. Dây cung được uốn bởi robot theo thiết kế riêng. Thời gian chế tác: 3-4 tuần.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">3</div>
					<div class="service-step__content">
						<p class="service-step__title">Gắn mắc cài gián tiếp (Indirect Bonding)</p>
						<p class="service-step__desc">Toàn bộ mắc cài được gắn cùng lúc bằng khay transfer chuyên dụng — đảm bảo vị trí chính xác tuyệt đối, buổi gắn kéo dài khoảng 60-90 phút.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">4</div>
					<div class="service-step__content">
						<p class="service-step__title">Tái khám & Điều chỉnh (mỗi 4-6 tuần)</p>
						<p class="service-step__desc">Bác sĩ kiểm tra tiến trình, thay dây cung, điều chỉnh lực kéo. Mỗi lần tái khám kéo dài 20-40 phút, theo dõi sát sao từng milimet dịch chuyển.</p>
					</div>
				</div>

				<div class="service-step">
					<div class="service-step__number">5</div>
					<div class="service-step__content">
						<p class="service-step__title">Tháo mắc cài & Duy trì kết quả</p>
						<p class="service-step__desc">Tháo mắc cài, đánh bóng răng. Lắp retainer mặt trong cố định (dây giữ dán mặt sau răng) kết hợp khay duy trì tháo lắp. Tái khám định kỳ 3-6 tháng.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Section: So sánh phương pháp ═══════════════════ -->
		<section class="service-content-section reveal" id="so-sanh">
			<h2 class="service-section-heading">So sánh với các phương pháp niềng khác</h2>
			<div class="gold-line-left"></div>

			<div class="service-prose">
				<p>Bảng so sánh nhanh giúp bạn hiểu rõ sự khác biệt giữa niềng mặt trong và các phương pháp chỉnh nha phổ biến khác:</p>
			</div>

			<div class="service-comparison-table-wrap">
				<table class="service-comparison-table">
					<thead>
						<tr>
							<th>Tiêu chí</th>
							<th>Mắc cài kim loại</th>
							<th>Mắc cài sứ</th>
							<th class="highlight-col">Niềng mặt trong</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Thẩm mỹ khi đeo</td>
							<td>★★☆☆☆</td>
							<td>★★★★☆</td>
							<td class="highlight-col"><strong>★★★★★</strong></td>
						</tr>
						<tr>
							<td>Hiệu quả điều trị</td>
							<td><strong>★★★★★</strong></td>
							<td>★★★★☆</td>
							<td class="highlight-col"><strong>★★★★★</strong></td>
						</tr>
						<tr>
							<td>Chi phí</td>
							<td>Từ 25 triệu</td>
							<td>Từ 35 triệu</td>
							<td class="highlight-col"><strong>Từ 80 triệu</strong></td>
						</tr>
						<tr>
							<td>Thời gian điều trị</td>
							<td>18-30 tháng</td>
							<td>18-30 tháng</td>
							<td class="highlight-col">18-36 tháng</td>
						</tr>
						<tr>
							<td>Xử lý ca phức tạp</td>
							<td><strong>Rất tốt</strong></td>
							<td>Tốt</td>
							<td class="highlight-col"><strong>Rất tốt</strong></td>
						</tr>
						<tr>
							<td>Độ bền mắc cài</td>
							<td><strong>Rất cao</strong></td>
							<td>Trung bình</td>
							<td class="highlight-col"><strong>Cao</strong></td>
						</tr>
						<tr>
							<td>Mức độ ẩn</td>
							<td>Nhìn thấy rõ</td>
							<td>Nhìn gần thấy</td>
							<td class="highlight-col"><strong>Ẩn 100%</strong></td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>

		<!-- ══ Section: Cam kết tại Pi ════════════════════════ -->
		<section class="service-content-section reveal" id="cam-ket">
			<h2 class="service-section-heading">Cam kết khi niềng tại Pi Dentist</h2>
			<div class="gold-line-left"></div>

			<div class="service-features-grid">
				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/><polyline points="9 12 11 14 15 10"/></svg>
					</div>
					<div>
						<h4>Bảo hành kết quả</h4>
						<p>Cam kết kết quả điều trị đúng như phác đồ đã thống nhất. Nếu chưa đạt — tiếp tục điều trị miễn phí.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
					</div>
					<div>
						<h4>Trả góp 0% lãi suất</h4>
						<p>Hỗ trợ trả góp linh hoạt lên đến 12 tháng qua thẻ tín dụng, giúp tối ưu ngân sách điều trị.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
					</div>
					<div>
						<h4>Chi phí minh bạch</h4>
						<p>Báo giá trọn gói từ đầu — không phát sinh, không chi phí ẩn. Bao gồm tái khám, thay dây, retainer.</p>
					</div>
				</div>

				<div class="service-feature-card">
					<div class="service-feature-card__icon">
						<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
					</div>
					<div>
						<h4>Bác sĩ chuyên sâu phụ trách</h4>
						<p>Mỗi bệnh nhân được 1 bác sĩ chỉnh nha chuyên trách theo dõi từ đầu đến cuối — không chuyển tay.</p>
					</div>
				</div>
			</div>
		</section>

		<!-- ══ Inline CTA ═════════════════════════════════════ -->
		<div class="service-inline-cta reveal">
			<h3>Sẵn sàng chỉnh nha kín đáo tuyệt đối?</h3>
			<p>Đặt lịch tư vấn miễn phí để được bác sĩ đánh giá tình trạng, tư vấn phương pháp niềng mặt trong phù hợp nhất cho bạn.</p>
			<a href="<?php echo esc_url( home_url( '/lien-he/' ) ); ?>" class="btn btn-gold">
				Đặt lịch tư vấn miễn phí
				<span aria-hidden="true">→</span>
			</a>
		</div>

	</div><!-- /.service-detail__content -->

</div><!-- /.service-detail__layout -->
